<h1>Solicitações</h1>
    <table>
        <tr>
            <th></th>
            <th></th>
            <th>Usuario</th>
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
                    <form action="<?= URL_RAIZ . 'administrador' ?>" method="post">
                        <input type="hidden" name="solicitacao" value="<?= $solicitacao->getId() ?>">
                        <a href="" onclick="event.preventDefault(); this.parentNode.submit()">
                            atender
                        </a>
                    </form>
                </td>
                <td>
                    <form action="<?= URL_RAIZ . 'administrador' ?>" method="post">
                        <input type="hidden" name="_metodo" value="DELETE">
                        <input type="hidden" name="solicitacao" value="<?= $solicitacao->getId() ?>">
                        <a href="" onclick="event.preventDefault(); this.parentNode.submit()">
                            deletar
                        </a>
                    </form>
                </td>
                <td><?= $solicitacao->getUsuario()->getEmail() ?></td>
                <td><?= $solicitacao->getReservado() ?></td>
                <td><?= $solicitacao->getDataInicio() ?></td>
                <td><?= $solicitacao->getDataFim() ?></td>
                <td><?= $solicitacao->getLaboratorio() ?></td>
                <td><?= $solicitacao->getMotivo() ?></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>