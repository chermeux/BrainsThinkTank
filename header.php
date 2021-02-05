        <header>
            <?php if (isset($message)): ?>
            <div class="alert alert-success" >
                <?php echo $message ?>
            </div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" >
                    <?php echo $error ?>
                </div>
            <?php endif; ?>

            <div id="logo">
                <a href="index.php"><img src="images/1_generales/Logo_agora.png" alt="Brains Think Tank" /></a>
            </div>
            <div id="barreNav">
                <nav>
                    <ul>
                        <li id="accueil"><a href="index.php">Accueil</a></li>
                        <li id="evenement"><a href="evenements.php">Evenements</a></li>
                        <li id="articles"><a href="articles.php">Articles</a></li>
                        <li id="contact"><a href="contact.php">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </header>