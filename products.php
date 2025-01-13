<?php
error_reporting(0);
session_start();
require_once "connect.php";
require_once "functions.php";

require_once "includes/auth/header.php";
require_once "includes/auth/menu.php";


$query_products = "SELECT 
                        id,
                        name,
                        description,
                        category,
                        amount,
                        status
                   FROM products;";

$result_products = mysqli_query($conn, $query_products);
if (!$result_products) {
    echo mysqli_error($conn);
    exit;
}

$products = array();

while ($row=mysqli_fetch_assoc($result_products)) {
    $products[$row['id']]['id'] = $row['id'];
    $products[$row['id']]['name'] = $row['name'];
    $products[$row['id']]['description'] = $row['description'];
    $products[$row['id']]['category'] = $row['category'];
    $products[$row['id']]['amount'] = $row['amount'];
    $products[$row['id']]['status'] = $row['status'];
}
?>
<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            </div>
        </nav>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Products</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li class="active">
                    <strong>Products</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <input type="hidden"  id = "product_id" value="">

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <?php foreach ($products as $id => $data) { ?>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                [ INFO ]
                            </div>
                            <div class="product-desc">
                                <span class="product-price">
                                    <?=$data['amount']?>
                                </span>
                                <small class="text-muted"> <?=$data['category']?></small>
                                <a href="#" class="product-name">  <?=$data['name']?></a>
                                <div class="small m-t-xs">
                                    <?=$data['description']?>
                                </div>
                                <div class="m-t text-righ">

                                    <a onclick="fillProductId('<?=$id?>');" href="#" class="btn btn-xs btn-outline btn-primary" data-toggle="modal" data-target="#addNewCard">
                                        Paguaj </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


        <!-- Modali dhe karta --!>
        <div class="modal inmodal" id="addNewCard" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeInDown">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal"><span
                                    aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <div class="row">
                            <div class="col-md-4">
                                <h2>Permbledhje</h2>
                                <strong>Produkti:</strong>: Produkti 1 <br/>
                                <strong>Cmimi:</strong>: <span class="text-navy">$452.90</span>
                            </div>
                            <div class="col-md-8">
                                <!-- Used to display form errors -->
                                <div id="card-errors" role="alert"></div>
                                <br>
                                <form role="form" id="payment-form">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>Mbajtesi i kartes</label>
                                                <input type="text" class="form-control" id = "cardholder_name" name="cardholder_name"
                                                       placeholder="Emri dhe Mbiemri"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>Vendosni Karten</label>
                                                <div id="card-element" class="form-control">
                                                    <!-- a Stripe Element will be inserted here. -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <span class="text-danger" id="card_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close
                        </button>
<!--                        <button type="button" id = "card-button" class="btn btn-primary">Paguaj <i class="fa fa-money"></i></button>-->

                        <button id = "card-button" class="ladda-button btn btn-primary" data-style="expand-right">Paguaj</button>

                    </div>
                </div>
            </div>
        </div>




    </div>
</div>
</div>


<?php
require_once "includes/auth/footer.php";
?>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    function fillProductId(id){
        $("#product_id").val(id);
    }
    function openNewCardModal() {
        $("#createPayment").modal("hide");
        $("#addNewCard").modal("show");
    }

    /**_______________________ Stripe JS ____________________________**/


    /**
     * Marrja e nje setup intent nga backend gati per tu vendosur vendosur te nje customer
     * nese ai do te krijoje nje karte te re per pagesa. Ne te kundert perdor nje qe ka aktualisht
     */
    //Collect payment method details on the client
    var stripe = Stripe("pk_test_51QdZaOIA6j8AgjdoONN2YmHKTojcogE82ZcF8ntm0l1YwdZNUKNnlDgxb62vZ7IBVbS1NfyGQoRNxjWn6o0bvJxE00alHhiENc");
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');
    ////Submit the card details to Stripe from the client
    var cardButton = document.getElementById('card-button');
    var cardError = document.getElementById('card-errors');
    //// rely on setup intent fetched above instead.
    var clientSecret = cardButton.dataset.secret;


    var l = $( '.ladda-button' ).ladda();

    cardButton.addEventListener('click', function (ev) {
       ev.preventDefault();
        // error message empty
        $("#card_error").text('');

       //bejme disable butonin
       // start the spin to the button
       l.ladda( 'start' );

       var cardholderName = $("#cardholder_name").val();
       if (isEmpty(cardholder_name)) {
           $("#cardholder_name").addClass("error-input");
           return;
       } else {
           $("#cardholder_name").removeClass("error-input");
       }

       var setupIntent;

       var finish_setup_intent = $.ajax({
           url: 'ajax_payment.php',
           method: 'POST',
           type: 'POST',
           cache: false,
           data: {
               "action": "setup_intents"
           },
           success: function (res) {
               var response = JSON.parse(res);
               if (response.status == 200) {
                   setupIntent = response.setup_intent;
               }
           }
       });

       finish_setup_intent.done(function () {
           // debug('handling card setup...');
           // new code that uses confirmCardSetup:
           stripe.confirmCardSetup(
               setupIntent.client_secret, {
                   payment_method: {
                       card: cardElement,
                       billing_details: {
                           name: cardholderName.value,
                       },
                   },
               }
           ).then(function (result) {
               if (result.error) {
                   l.ladda('stop');
                   $("#card_error").text(result.error.message);
               } else {
                   l.ladda('stop');
                   $("#card_error").text('');
                   createCustomer_and_pay(result.setupIntent.payment_method);
               }
           });
       });
    });

    function createCustomer_and_pay(paymentMethod) {

        // debug('Creating customer...');
        $("#card_error").text(''); // error message
        var cardholder_name = $("#cardholder_name").val();
        var product_id = $("#product_id").val();

        //bejme disable butonin
        // $("#card-button").attr("disabled", true);
        l.ladda('start');

        $.ajax({
            url: 'ajax_payment.php',
            method: 'POST',
            type: 'POST',
            cache: false,
            data: {
                "action": "create_customer_and_pay",
                "payment_method": paymentMethod,
                "cardholder_name": cardholder_name,
                "product_id": product_id,
            },
            success: function (res) {
                var res = JSON.parse(res);
                if (res.status == 404) {
                    // cardError.innerText = res.message;
                    // debug(res.message);
                    l.ladda('stop')
                    // if (res.error_code != "authentication_required") {
                    //     swal("Error", res.message, "error");
                    //
                    //     //bejme enable buttonin ne rast errori qe te plotesoj te dhena te sakta perseri
                    //     // $("#card-button").removeAttr('disabled');
                    //
                    // }
                    // Duhet bere nje thirje Ajax qe te mund te ruhen te dhenat e pageses pasi behet konfirmimi i kartes
                    // if (res.error_code == "authentication_required") {
                    //     var paymentIntent = res.payment_intent;
                    //     var paymentMethodId = res.payment_method;
                    //
                    //     stripe.handleCardPayment(
                    //         paymentIntent.client_secret, {
                    //             payment_method: paymentMethodId
                    //         }
                    //     ).then(function (result) {
                    //         if (result.error) {
                    //             swal(result.error.message, '', "error");
                    //         } else {
                    //             if (result.paymentIntent.status === 'succeeded') {
                    //                 confirmPayment(paymentIntent.id, paymentMethodId);
                    //             }
                    //         }
                    //     });
                    // }

                } else {
                    swal("Sukses", res.message, "success");
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                    // debug('Created customer: ' + res.customer_id);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }

        });
    }

    //function confirmPayment(paymentIntent, paymentMethodId) {
    //
    //    var product_id = 1;
    //    var cardholder_name = $("#cardholder_name").val();
    //    var data = new FormData();
    //
    //    data.append("action", "confirmPayment");
    //    data.append("payment_method", paymentMethodId);
    //    data.append("cardholder_name", cardholder_name);
    //    data.append("paymentIntent", paymentIntent);
    //    data.append("product_id", product_id);
    //
    //    fetch('ajax_payment.php', {
    //            method: 'POST',
    //            body: data
    //        },
    //
    //    ).then(function (res) {
    //        return res.json();
    //    }).then(function (response) {
    //
    //
    //        if (response.status != 404) {
    //            swal("Success", response.message, "success");
    //            setTimeout(function () {
    //                location.reload();
    //            }, 3000);
    //        } else {
    //            swal("Error", response.message, "warning");
    //            setTimeout(function () {
    //                location.reload();
    //            }, 3000);
    //        }
    //    });
    //}
    //


</script>
