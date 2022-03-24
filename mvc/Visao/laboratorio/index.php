<div class="pagina-index">
    <div class="solicitacoes-usuario">
        <h1>Solicitações de <?= $usuario->getEmail() ?></h1>

            <table>
                <tr>
                    <th></th>
                    <th>Reservado</th>
                    <th>Data de inicio</th>
                    <th>Data de término</th>
                    <th>laboratorio</th>
                    <th>Motivo</th>
                </tr>
                <?php if (empty($solicitacoes)) : ?>
                    <tr>
                        <td colspan="99">Nenhuma solicitação realizada.</td>
                    </tr>
                <?php endif ?>
                <?php foreach ($solicitacoes as $solicitacao) : ?>
                    <tr>
                        <td>
                            <form action="<?= URL_RAIZ . 'laboratorio' ?>" method="post">
                                <input type="hidden" name="solicitacao" value="<?= $solicitacao->getId() ?>">
                                <input type="hidden" name="_metodo" value="DELETE">
                                <a href="" onclick="event.preventDefault(); this.parentNode.submit()">
                                    Deletar
                                </a>
                            </form>
                        </td>
                        <td><?= $solicitacao->getReservado() ?></td>
                        <td><?= $solicitacao->getDataInicio() ?></td>
                        <td><?= $solicitacao->getDataFim() ?></td>
                        <td><?= $solicitacao->getLaboratorio() ?></td>
                        <td><?= $solicitacao->getMotivo() ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
    </div>
    <div>
        <h1>Selecione o laboratório em que deseja realizar a solicitação</h1>
        <div class="laboratorios-img">
            <div class="laboratorios">
                <a class="laboratorio1" href="<?= URL_RAIZ . 'laboratorio/1' ?>">Laboratório 1</a><br>
                <a class="laboratorio2" href="<?= URL_RAIZ . 'laboratorio/2' ?>">Laboratório 2</a><br>
                <a class="laboratorio3" href="<?= URL_RAIZ . 'laboratorio/3' ?>">Laboratório 3</a><br>
                <a class="laboratorio4" href="<?= URL_RAIZ . 'laboratorio/4' ?>">Laboratório 4</a><br>
                <a class="laboratorio5" href="<?= URL_RAIZ . 'laboratorio/5' ?>">Laboratório 5</a><br>
            </div>
            <img alt="Laboratorios" src="<?= URL_IMG . 'laboratorios.jpg'?>">
        </div>
    </div>

</div>
