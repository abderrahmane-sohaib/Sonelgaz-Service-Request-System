// npm package: sweetalert2
// github link: https://github.com/sweetalert2/sweetalert2

// resources/js/app.js (or your main entry point)

$(function () {
    showSwal = function (type) {
        "use strict";
        if (type === "basic") {
            swal.fire({
                text: "Any fool can use a computer",
                confirmButtonText: "Close",
                confirmButtonClass: "btn btn-danger",
            });
        } else if (type === "title-and-text") {
            Swal.fire(
                "The Internet?",
                "That thing is still around?",
                "question"
            );
        } else if (type === "title-icon-text-footer") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
                footer: "<a href>Why do I have this issue?</a>",
            });
        } else if (type === "custom-html") {
            showSwal = function (type, ingenieurId) {
                // Ajoutez ingenieurId comme paramètre
                "use strict";
                if (type === "custom-html") {
                    // Effectuer une requête AJAX pour récupérer les données de l'ingénieur
                    // $.ajax({
                    //     url: "/dashboard/admin/" + ingenieurId, // Utilisez ingenieurId dans l'URL de la requête AJAX
                    //     type: "GET",
                    //     success: function (response) {
                            Swal.fire({
                                title: "<strong>Edit Account</strong>",
                                icon: "info",
                                html: `
                                    <form id="updateForm" method="POST"   class="bg-gray-100">
                                    
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nom</label>
                                            <input id="name" class="form-control" name="name" type="text" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="prenom" class="form-label">Prénom</label>
                                            <input id="prenom" class="form-control" name="prenom" type="text" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input id="email" class="form-control" name="email" type="email" >
                                        </div>
                                        <div class="mb-3">
                                 <label for="password" class="form-label">Password</label>
                                 <input id="password" class="form-control" name="password" type="password" >
                                </div>
                               
                                <button type="submit"  class="btn btn-inverse-primary">submit</button>
                                    </form>
                                `,
                                showCloseButton: true,
                                showConfirmButton: false,
                                focusConfirm: false,
                            });

                            

                            // feather.replace();
                    //     },
                    //     error: function (xhr, status, error) {
                    //         console.error(xhr.responseText);
                    //     },
                    // });

                  
                }
            };
            feather.replace();
        } else if (type === "custom-position") {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your work has been saved",
                showConfirmButton: false,
                timer: 1500,
            });
        } else if (type === "passing-parameter-execute-cancel") {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger me-2",
                },
                buttonsStyling: false,
            });

            swalWithBootstrapButtons
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "me-2",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.value) {
                        swalWithBootstrapButtons.fire(
                            "Deleted!",
                            "Your file has been deleted.",
                            "success"
                        );
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            "Cancelled",
                            "Your imaginary file is safe :)",
                            "error"
                        );
                    }
                });
        } else if (type === "message-with-auto-close") {
            let timerInterval;
            Swal.fire({
                title: "Auto close alert!",
                html: "I will close in <b></b> milliseconds.",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    timerInterval = setInterval(() => {
                        const content = Swal.getHtmlContainer();
                        if (content) {
                            const b = content.querySelector("b");
                            if (b) {
                                b.textContent = Swal.getTimerLeft();
                            }
                        }
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                }
            });
        } else if (type === "message-with-custom-image") {
            Swal.fire({
                title: "Sweet!",
                text: "Modal with a custom image.",
                // imageUrl: 'https://unsplash.it/400/200',
                imageUrl: "../../../assets/images/others/placeholder.jpg",
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: "Custom image",
            });
        } else if (type === "mixin") {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: "success",
                title: "Signed in successfully",
            });
        }
    };
});
