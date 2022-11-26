<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PayStack Check </title>
    <link rel="stylesheet" href="assets/css/myapp.css">
    <script src="assets/js/myapp.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Payment Check</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-md-center">Payment Method with API</p>
                        <form action="charge-amount" method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount" >
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="Enter Phone"  >
                            </div>
                            <div class="form-group mb-4">
                                <label for="provider">Provider</label>
                                <select name="provider" id="provider" class="form-control" required>
                                    <option value="mtn">MTN</option>
                                    <option value="vod">VODAFONE</option>
                                    <option value="tgo">AIRTEL/TIGO</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Confirm Payment</button>
                        </form>
                    </div
                </div>
            </div>
        </div>
    </div>
    <script>
        st(document).ready(function() {
            st("form[action=charge-amount]").on('submit', function(e) {
                e.preventDefault();
                let email = "", amount = "", phone = "", provider = "";
                email = st("#email").val();
                amount = st("#amount").val();
                if(amount === "") amount = 0;
                phone = st("#phone").val();
                provider = st("#provider").val();

                swal.fire({
                    title: "Are you sure?",
                    text: "We will charge you GHS " + amount + " for this transaction",
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonColor: "rgba(230,126,22,0.84)",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, make payment!",
                    cancelButtonText: "No, cancel!",
                    showClass: {
                        popup: 'animate__animated animate__bounce',
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutLeft'
                    }
                }).then((response)=>{
                    if(!response.isConfirmed){
                        swal.fire({
                            title: "Cancelled",
                            text: "Payment Cancelled",
                            icon: "error",
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown',
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutLeft'
                            }
                        });
                    } else {
                        st.ajax({
                            // url: 'charge',
                            url: 'api/v1/controller/charge.php',
                            type: 'POST',
                            data: {
                                email: email,
                                amount: amount,
                                phone: phone,
                                provider: provider
                            }
                        }).done(function(response){
                            if(!response.success) {
                                alert(response);
                                swal.fire({
                                    title: "Error",
                                    text: "Check Input Fields " + response.response,
                                    icon: "error",
                                    showClass: {
                                        popup: 'animate__animated animate__fadeInDown',
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutLeft'
                                    }
                                });
                            } else {
                                swal.fire({
                                    title: "Success",
                                    html: "Payment Successful <br> <b>Transaction Reference: </b>" + response.data.data.reference,
                                    icon: "success",
                                    showClass: {
                                        popup: 'animate__animated animate__fadeInDown',
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutLeft'
                                    }
                                });
                            }
                        }).fail(function(error){
                            swal.fire({
                                text: "Error Occurred At Your End!",
                                icon: "error",
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown',
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutLeft'
                                }
                            });
                            console.debug(error.responseJSON.response);
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>