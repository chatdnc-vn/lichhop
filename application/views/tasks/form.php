<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $task ? 'Sửa công việc' : 'Thêm công việc' ?></title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; color: #222; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input[type=text], input[type=datetime-local], textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        .errors { color: #c0392b; }
        .btn { display: inline-block; padding: 8px 16px; background: #2563eb; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-top: 16px; }
        a.back { display: inline-block; margin-top: 16px; margin-left: 8px; }
    </style>
</head>
<body>
    <h1><?= $task ? 'Sửa công việc' : 'Thêm công việc mới' ?></h1>

    <?= validation_errors('<div class="errors">', '</div>') ?>

    <?php
        $action = $task ? site_url('tasks/update/' . $task->id) : site_url('tasks/create');
        $due_value = $task ? date('Y-m-d\TH:i', strtotime($task->due_date)) : '';
    ?>
    <form action="<?= $action ?>" method="post">
        <label for="title">Tên công việc</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($task->title ?? set_value('title')) ?>" required>

        <label for="description">Mô tả</label>
        <textarea id="description" name="description" rows="4"><?= htmlspecialchars($task->description ?? set_value('description')) ?></textarea>

        <label for="due_date">Hạn hoàn thành</label>
        <input type="datetime-local" id="due_date" name="due_date" value="<?= $due_value ?>" required>

        <button type="submit" class="btn"><?= $task ? 'Lưu thay đổi' : 'Thêm công việc' ?></button>
        <a class="back" href="<?= site_url('tasks') ?>">Quay lại</a>
    </form>
</body>
</html>
