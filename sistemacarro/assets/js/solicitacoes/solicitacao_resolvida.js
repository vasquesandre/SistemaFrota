function solicitacaoResolvida(index) {
    console.log("res")
    $.ajax({
        url: '../../../sistemacarro/php/scriptsajax/solicitacoes/marcar_resolvido.php',
        type: 'POST',
        data: {
            index: index
        },
        dataType: 'json',
        success: function (response) {
            var toastMessage = response.message;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                carregarNaoResolvidos();
            } else if (response.status === "warning") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Campo em branco");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-success").addClass("bg-warning");
                $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-x").addClass("bx-edit-alt");
            } else {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Error");
                $(".toast-placement-ex").removeClass("bg-success").removeClass("bg-warning").addClass("bg-danger");
                $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-edit-alt").addClass("bx-x");
            }

            $(".toast-placement-ex .toast-body").text(toastMessage);

            $("#showToastPlacement").click();
        }
    })
}