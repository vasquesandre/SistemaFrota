<div class="modal fade" id="modalVeiculo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="mb-3">
                        <label for="placa_veiculo" class="form-label">Placa do Veiculo</label>
                        <div class="form-check form-switch mb-2 float-end">
                            <label class="form-check-label" for="flexSwitchCheckChecked"
                            >Placa Mercosul</label
                            >
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked />
                        </div>
                        <input type="text" class="form-control" id="placa_veiculo" placeholder="___-____"/>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3">
                        <label class="form-label" for="modelo_veiculo">Modelo do Veiculo</label>
                        <input type="text" class="form-control" id="modelo_veiculo" placeholder="Ex: Mobi" disabled/>
                        <em id="veiculoEncontrado"></em>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" id="addCarBtn" class="btn btn-primary" disabled>Adicionar Veiculo</button>
            </div>
        </div>
    </div>
</div>