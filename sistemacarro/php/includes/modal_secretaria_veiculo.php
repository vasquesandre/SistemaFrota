<div class="modal fade" id="modalSecretariaVeiculo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSecretariaVeiculoTitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="mb-3">
                        <label for="secretaria" class="form-label">Secretaria</label>
                        <select id="secretaria" class="form-select" name="secretaria" onchange="verificarSecretaria()">
                            <option value="default">Selecione a Secretaria</option>
                            <?php
                            $query = "SELECT id_secretaria, nome_secretaria FROM tb_secretaria";
                            $result = mysqli_query($conn, $query);

                            // Verifica se há resultados
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['id_secretaria'] . '">' . $row['nome_secretaria'] . '</option>';
                                }
                            } else {
                                echo '<option value="">Nenhuma secretaria encontrada</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" id="saveBtn" class="btn btn-primary" disabled>Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>