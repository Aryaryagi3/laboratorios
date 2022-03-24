<div class="pagina-lab">
    <div class="solicitacoes-lab">
    <h1>Laboratório <?= $laboratorioId ?></h1>

    <table>
            <tr>
                <th>Reservado</th>
                <th>Data de inicio</th>
                <th>Data de término</th>
                <th>Laboratorio</th>
                <th>Usuario</th>
            </tr>
            <?php if (empty($solicitacoes)) : ?>
                <tr>
                    <td colspan="99">Nenhuma reserva ainda foi realizada.</td>
                </tr>
            <?php endif ?>
            <?php foreach ($solicitacoes as $solicitacao) : ?>
                    <tr>
                        <td><?= $solicitacao->getReservado() ?></td>
                        <td><?= $solicitacao->getDataInicio() ?></td>
                        <td><?= $solicitacao->getDataFim() ?></td>
                        <td><?= $solicitacao->getLaboratorio() ?></td>
                        <td><?= $solicitacao->getUsuario()->getEmail() ?></td>
                    </tr>
            <?php endforeach ?>
    </table>
    </div>
    <div class="realizar-solicitacao">
        <h1>Realizar Solicitação</h1>
            <div class="realizar-solicitacao-form-img">
                <div class="solicitacao-form">
                    <?php if ($mensagem) : ?>
                        <div class="mensagem-alerta">
                            <p><?= $mensagem ?></p>
                        </div>
                    <?php endif ?>
                    <form action="<?= URL_RAIZ . 'laboratorio/$id' ?>" method="post">
                        <input type="hidden" name="laboratorio" value="<?=  $laboratorioId ?>">
                        <label for="data-inicio">Data de inicio de uso:</label><br>
                        <input type="datetime-local" id="data-inicio" name="data-inicio" autofocus value="<?= $this->getPost('email') ?>">
                        <?php if ($this->temErro('dataInicio')) : ?>
                            <div class="erro">
                                <p><?= $this->getErro('dataInicio') ?></p>
                            </div>
                        <?php endif ?><br>
                        <label for="datafim">Data de fim de uso:</label><br>
                        <input type="datetime-local" id="data-fim" name="data-fim">
                        <?php if ($this->temErro('dataFim')) : ?>
                            <div class="erro">
                                <p><?= $this->getErro('dataFim') ?></p>
                            </div>
                        <?php endif ?><br>
                        <p>Bancadas a serem reservadas:</p>
                        <input type="checkbox" id="bancada1" name="bancada1" value="1">
                        <label for="bancada1">Bancada 1</label><br>
                        <input type="checkbox" id="bancada2" name="bancada2" value="2">
                        <label for="bancada2">Bancada 2</label><br>
                        <input type="checkbox" id="bancada3" name="bancada3" value="3">
                        <label for="bancada3">Bancada 3</label>
                        <?php if ($this->temErro('bancadas')) : ?>
                            <div class="erro">
                                <p><?= $this->getErro('bancadas') ?></p>
                            </div>
                        <?php endif ?><br>
                        <label for="motivo">Motivo de uso:</label><br>
                        <textarea id="motivo" name="motivo" cols="40" rows="3"><?= $this->getPost('motivo') ?></textarea>

                        <?php if ($this->temErro('motivo')) : ?>
                            <div class="motivo">
                                <p><?= $this->getErro('motivo') ?></p>
                            </div>
                        <?php endif ?><br>
                        <input type="submit" value="Submit">
                    </form>
                </div>

                <img alt="Laboratorios" src="<?= URL_IMG . 'bancadas.jpg'?>">
            </div>
    </div>
</div>