registrationModule
    .controller('registrationController', [
        '$scope'
        , '$http'
        , 'RegistrationForm'
        , 'ServiceableArea'
        , 'EmailValidator'
        , 'RegistrationAPI'
        , 'QuestionList'
        , '$location'
        , '$rootScope'
        , '$modal',
        function( $scope
                , $http
                , RegistrationForm
                , ServiceableArea
                , EmailValidator
                , RegistrationAPI
                , QuestionList
                , $location
                , $rootScope
                , $modal ) {

            $scope.passwordPattern = /^(?=[^\d_].*?\d)\w(\w|[!@#$%]){7,20}/;

            $scope.registrationForm         = new RegistrationForm();
            $scope.questionList             = QuestionList;
            $scope.serviceableAreas         = [];
            $scope.currentDistricts         = [];
            $scope.index                    = 0;
            $scope.isEmailExisting          = false;
            $scope.isSubmitButtonDisabled   = false;
            $scope.isCustomQuestion         = false;

            var onLoad = function() {
                loadResources();
            };

            var validateCurrentDistricts = function(index) {
                $scope.currentDistricts = $scope.serviceableAreas[index].districts;
                $scope.registrationForm.district = $scope.currentDistricts[0].districtName;
            };

            var loadResources = function() {
                ServiceableArea.get().then(function(results) {
                    $scope.serviceableAreas         = results;
                    $scope.registrationForm.city    = $scope.serviceableAreas[0].cityName;
                    validateCurrentDistricts(0);
                });
            };

            $scope.UpdateDistrict = function(area) {
                for (var counter = 0; counter < $scope.serviceableAreas.length; counter++) {
                    if ($scope.registrationForm.city == $scope.serviceableAreas[counter].cityName) {
                        validateCurrentDistricts(counter);
                        break;
                    }
                };
            };

            $scope.ValidateEmail = function() {
                EmailValidator.checkEmail($scope.registrationForm.email).then(function(results) {
                    results = results.trim();
                });
            };

            $scope.submitForm = function() {

                $scope.isSubmitButtonDisabled = true;

                RegistrationAPI.submitForm( $scope.registrationForm )
                    .success(function( results ) {
                        
                        results = results.trim();


                        if (results == 'true') {
                            $rootScope.newMember 		= {};
                            $rootScope.newMember.name 	= $scope.registrationForm.firstName;
                            $rootScope.newMember.email 	= $scope.registrationForm.email;

                            $location.path('/congratulations');
                        } 
                        else if( results == "Duplicate entry '"+$scope.registrationForm.email+"' for key 'PRIMARY'" ) {
                            swal("Email already registered!", "Please use another email.", "warning");
                        } 
                        else {
                            swal("Ooops!", "An error occured while processing your registration. Please try again later.", "error");
                        }

                        $scope.isSubmitButtonDisabled = false;
                    })
                    .error(function(results) {
                        $scope.isSubmitButtonDisabled = false;
                    })
            };

            onLoad();
        }
    ]);
