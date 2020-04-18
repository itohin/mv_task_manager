<section class="jumbotron text-center">
    <div class="container">
        <h1>Tasks List</h1>
            <a href="/tasks/create" class="btn btn-primary my-2">Create New</a>
    </div>
</section>

<div class="container w-75 pb-5">
    <?php foreach ($tasks as $task): ?>
        <div class="card mb-4">
            <div class="card-header">
                <?= $task->name ?>
                <?php if ($task->done) : ?>
                    <span class="badge badge-success ml-2">Done</span>
                <?php else : ?>
                    <span class="badge badge-warning ml-2">In progress</span>
                <?php endif ?>
            </div>
            <div class="card-body">
                <p><?= $task->content ?></p>
                <b><?= $task->email ?></b>
                <?php if (\App\Auth\Auth::check()) : ?>
                    <div>
                        <a href="tasks/<?= $task->id ?>" class="btn btn-danger" style="float:right">Edit</a>
                    </div>
                <?php endif ?>
            </div>
        </div>
    <?php endforeach ?>

    <div class="mb-5 mt-5">
        <nav>
            <ul class="pagination">
                <li class="page-item">
                    <?php if ($page > 1) : ?>
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                    <?php endif ?>
                </li>
                <?php  for ($i = 1; $i <= $total; $i ++) :?>
                    <li class="page-item">
                        <?php if ($i == $page) : ?>
                            <a class="page-link"><?= $i ?></a>
                        <?php else : ?>
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        <?php endif ?>
                    </li>
                <?php endfor ?>
                <?php if ($page < $total) : ?>
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                <?php endif ?>
            </ul>
        </nav>
    </div>
</div>
