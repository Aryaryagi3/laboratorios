<div class="entrar-conta">
    <h1>Entrar em uma Conta</h1>
        <?php if ($mensagem) : ?>
            <div class="mensagem-alerta">
                <p><?= $mensagem ?></p>
            </div>
        <?php endif ?>
        <form action="<?= URL_RAIZ . 'login' ?>" method="post">
            <?php if ($this->temErro('incorreto')) : ?>
                <div class="erro">
                    <p><?= $this->getErro('incorreto') ?></p>
                </div>
            <?php endif ?><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" autofocus value="<?= $this->getPost('email') ?>">
            <?php if ($this->temErro('email')) : ?>
                <div class="erro">
                    <p><?= $this->getErro('email') ?></p>
                </div>
            <?php endif ?><br>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha">
            <?php if ($this->temErro('senha')) : ?>
                <div class="erro">
                    <p><?= $this->getErro('senha') ?></p>
                </div>
            <?php endif ?><br>
            <input type="submit" value="submit">
        </form>
        <a href="<?= URL_RAIZ . 'usuarios/criar' ?>">Criar uma conta</a>
</div>
