document.addEventListener("DOMContentLoaded", function () {
  buscarSecretarias();
});

function adicionarSecretaria() {
  var nomeSecretaria = $("input[name='nome_secretaria']").val();

  $.ajax({
    url: "processa_secretarias.php",
    type: "POST",
    dataType: "json",
    data: {
      nome_secretaria: nomeSecretaria
    },
    success: function (response) {
      $("input[name='nome_secretaria']").val('');

      var toastMessage = response.message;

      if (response.status === "success") {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
        $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
        $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");
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

      buscarSecretarias();
    },
    error: function (xhr, status, error) {
      toastr.error('Erro ao adicionar secretaria: ' + error, 'Erro');
    }
  });
}

function buscarSecretarias() {
  $.ajax({
    type: 'POST',
    url: 'buscar_secretarias.php',
    dataType: 'json',
    success: function (response) {
      $('#secretarias_existentes').html('');

      if (response.length > 0) {
        $('#exists').show();

        var opcoesHTML = '<div class="mb-1">';
        for (var i = 0; i < response.length; i++) {
          opcoesHTML += '<div class="card card-secretaria">';
          opcoesHTML += '<span style="padding: 10px;">' + response[i] + '</span>';
          opcoesHTML += '<button type="button" class="btn btn-icon btn-renomear-secretaria" data-bs-toggle="modal" data-bs-target="#modalCenterRenomear"><i class="bx bxs-edit-alt"></i></button>';
          opcoesHTML += '<button type="button" class="btn btn-icon btn-excluir-secretaria" data-bs-toggle="modal" data-bs-target="#modalCenter"><i class="bx bx-x"></i></button>';
          opcoesHTML += '</div>';
        }
        opcoesHTML += '</div>';
        $('#secretarias_existentes').html(opcoesHTML);
      } else {
        $('#exists').hide();
      }
    },
    error: function (error) {
      console.log("Erro na solicitação AJAX: ", error);
    }
  });
}

function renomearOpcao(nomeSecretaria, novoNomeSecretaria) {

  $.ajax({
    url: 'renomear_secretaria.php',
    method: 'POST',
    data: {
      secretaria: nomeSecretaria,
      novoNome: novoNomeSecretaria
    },
    dataType: 'json',
    success: function (response) {
      var toastMessage = response.message;

      if (response.status === "success") {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
        $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
        $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

        buscarSecretarias();
      } else {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Error");
        $(".toast-placement-ex").removeClass("bg-success").removeClass("bg-warning").addClass("bg-danger");
        $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-edit-alt").addClass("bx-x");
      }

      $(".toast-placement-ex .toast-body").text(toastMessage);

      $("#showToastPlacement").click();
    },
    error: function (error) {
      console.log("Erro na solicitação AJAX: ", error);
    }
  })
}

function excluirOpcao(index) {  
  $.ajax({
    url: 'excluir_secretaria.php',
    method: 'POST',
    data: {
      secretaria : index
    },
    dataType: 'json',
    success: function (response) {
      var toastMessage = response.message;

      if (response.status === "success") {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
        $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
        $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

        buscarSecretarias();
      } else {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Error");
        $(".toast-placement-ex").removeClass("bg-success").removeClass("bg-warning").addClass("bg-danger");
        $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-edit-alt").addClass("bx-x");
      }

      $(".toast-placement-ex .toast-body").text(toastMessage);

      $("#showToastPlacement").click();
    },
    error: function (error) {
      console.log("Erro na solicitação AJAX: ", error);
    }
  })
}


$('#modalCenter').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var nomeSecretaria = button.siblings('span').text();
  var modal = $(this);

  modal.find('.modal-title').text(nomeSecretaria);

  modal.find('.btn-danger').off('click').on('click', function () {
    excluirOpcao(nomeSecretaria);
    modal.modal('hide');
  });
});


$('#modalCenterRenomear').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var nomeSecretaria = button.siblings('span').text();
  var modal = $(this);

  modal.find('.modal-title').text(nomeSecretaria);

  modal.find('.btn-warning').off('click').on('click', function () {
    var novoNomeSecretaria = modal.find('#nameWithTitle').val();
    renomearOpcao(nomeSecretaria, novoNomeSecretaria);
    modal.modal('hide');
  });
});


/**
 * UI Toasts
 */

'use strict';

(function () {
  // Bootstrap toasts example
  // --------------------------------------------------------------------
  const toastPlacementExample = document.querySelector('.toast-placement-ex'),
    toastPlacementBtn = document.querySelector('#showToastPlacement');
  let toastPlacement;

  // Dispose toast when open another
  function toastDispose(toast) {
    if (toast && toast._element !== null) {
      toast.dispose();
    }
  }
  // Placement Button click
  if (toastPlacementBtn) {
    toastPlacementBtn.onclick = function () {
      if (toastPlacement) {
        toastDispose(toastPlacement);
      }

      toastPlacement = new bootstrap.Toast(toastPlacementExample);
      toastPlacement.show();
    };
  }
})();
