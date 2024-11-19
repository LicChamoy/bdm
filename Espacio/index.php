<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Sandbox Integration</title>

    <!-- SDK de PayPal con el Client ID de Sandbox -->
    <script src="https://www.paypal.com/sdk/js?client-id=AfkdkuUunGUsOA1Jpb6MtBSoN67CVJj8QQQo20DyC_rXJB4m_I55qAyTotsef3ihpZr7OK2XIOmLKnYe&currency=MXN"></script>
</head>
<body>
   
    <div id="paypal-button-container"></div>

    <script>
        // Renderizar el botón de PayPal
        paypal.Buttons({
            style:{
                color:'blue',
                shape:'pill'
            },
            createOrder:function(data, actions){
                return actions.order.create({
                    purchase_units:[{
                        amount: {
                            value: 100
                        }
                    }]
                })
            },

            onApprove:function(data, actions){
                console.log("Pago aprobado: ", data);
                actions.order.capture().then(function(detalles){
                    console.log("Detalles del pago: ", detalles);
                    // Verifica si la transacción está completa y redirige
                    if (detalles.status === 'COMPLETED') {
                        console.log("Pago completado, redirigiendo...");
                        window.location.href="Espacio/completado.html";
                    } else {
                        console.log("El pago no se completó correctamente");
                    }
                }).catch(function(error) {
                    console.log("Error al capturar el pago: ", error);
                });
            },

            onCancel:function(data){
                alert("Pago Cancelado");
                console.log("Datos de cancelación: ", data);
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
