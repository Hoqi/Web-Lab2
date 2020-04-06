<?php if (isset($_SESSION['id'])) : ?>
    <?php
    require $_SERVER['DOCUMENT_ROOT'].'/../libs/db.php';
    $DB = new DataBase();
    if (isset($_SESSION['db_error'])){
        echo 'Нет доступа к данным';
        unset($_SESSION['db_error']);
        die();
    }
    if ($_SESSION['access_level'] == 'user') {
        $header = 'Ваши доклады';
        $reports = $DB->getReportsByUserId($_SESSION['id']);
    } else {
        $header = 'Все доклады';
        $reports = $DB->getAllReports();
        $users = $DB->getAllUsersShortInfo();
    }
    ?>
    <div class="reports">
        <div class="reports_header">
            <?= $header ?>
        </div>
        <?php if ($reports != null) : ?>
            <?php foreach ($reports as $report) : ?>
                <div class="report">
                    <div class="title">
                        <span><strong>Название доклада: </strong></span>
                        <a href="showinfo.php?id=<?= $report['id']; ?>"><?= $report['title']; ?></a>
                    </div>
                    <?php if ($_SESSION['access_level'] == 'admin') : ?>
                        <div class="userName">
                            <span><strong>Имя отправителя: </strong></span>
                            <span><?= $users[$report['user_id']]['name'] ?></span>
                        </div>
                        <div class="userEmail">
                            <span><strong>Email отправителя: </strong></span>
                            <span><?= $users[$report['user_id']]['email'] ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="category">
                        <span><strong>Категория: </strong></span>
                        <span><?= $report['category']; ?></span>
                    </div>
                    <div class="aboutReport">
                        <span><strong>Краткая информация: </strong></span>
                        <span><?= $report['short_inforeport']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="report">
                <span>У вас пока нет докладов</span>
            </div>
        <?php endif; ?>
        <div>
            <a href="reportAdd.php">Добавить доклад</a>
        </div>
    </div>
<?php endif; ?>