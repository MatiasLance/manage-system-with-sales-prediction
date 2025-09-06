
jQuery(function($){
    $(document).on('click', '.logout, #logout', function() {
        $.ajax({
            url: './controller/LogoutController.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: false
                    });
                    setTimeout(function(){
                        window.location.href = response.redirect;
                    }, 1000)
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    })

    $(document).on('click', '#loginToPOS', function() {
        let timerInterval;
        Swal.fire({
            title: "Redirecting to POS...",
            html: "You will be redirected in <b>2</b> seconds.",
            timer: 2000,
            timerProgressBar: true,
            allowEscapeKey: false,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                
                timerInterval = setInterval(() => {
                    const timeLeft = Math.ceil(Swal.getTimerLeft() / 1000);
                    if (timer) {
                        timer.textContent = timeLeft;
                    }
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                window.location.href = '/pos';
            }
        });
    });
})