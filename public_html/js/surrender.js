 $("#mydropzone").dropzone({
            url: "../resources/lib/surrender_handler.php" ,
            autoProcessQueue: false,
            uploadMultiple: true, //if you want more than a file to be   uploaded
            addRemoveLinks:true,
            maxFiles: 10,
            previewsContainer: '#previewDiv',

            init: function () {
                console.log("init");
                var submitButton = document.querySelector("#submitForm");
                var wrapperThis = this;

                submitButton.addEventListener("click", function () {
                    wrapperThis.processQueue();
                });

                this.on("addedfile", function (file) {

                    // Create the remove button
                    var removeButton = Dropzone.createElement("<button class=\"yourclass\"> Remove File</button>");

                    // Listen to the click event
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        wrapperThis.removeFile(file);
                   });

                    file.previewElement.appendChild(removeButton);
                });

            // Also if you want to post any additional data, you can do it here
                this.on('sending', function (data, xhr, formData) {
                    formData.append("PKId", $("#PKId").val());
                });

                this.on("maxfilesexceeded", function(file) {
                    alert('max files exceeded');
                    // handle max+1 file.
                });
            }
        });