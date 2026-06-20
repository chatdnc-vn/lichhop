<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhắc việc cần làm</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; color: #222; }
        h1 { margin-bottom: 4px; }
        .toolbar { margin: 16px 0; display: flex; justify-content: space-between; align-items: center; }
        .message { background: #e6ffed; border: 1px solid #b7e7c2; padding: 8px 12px; border-radius: 4px; margin-bottom: 16px; }
        .due-soon { background: #fff7e6; border: 1px solid #ffe2a8; padding: 8px 12px; border-radius: 4px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
        .done { text-decoration: line-through; color: #888; }
        .actions a { margin-right: 8px; }
        .btn { display: inline-block; padding: 6px 12px; background: #2563eb; color: #fff; border-radius: 4px; text-decoration: none; }
        .overdue { color: #c0392b; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Danh sách công việc cần làm</h1>

    <?php if ($this->session->flashdata('message')): ?>
        <div class="message"><?= htmlspecialchars($this->session->flashdata('message')) ?></div>
    <?php endif; ?>

    <?php if (!empty($due_soon)): ?>
        <div class="due-soon">
            ⏰ Có <?= count($due_soon) ?> công việc sắp đến hạn trong 24 giờ tới.
        </div>
    <?php endif; ?>

    <div class="toolbar">
        <div>
            <a href="<?= site_url('tasks') ?>">Tất cả</a> |
            <a href="<?= site_url('tasks?filter=pending') ?>">Chưa hoàn thành</a>
        </div>
        <a class="btn" href="<?= site_url('tasks/new_form') ?>">+ Thêm công việc</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tên công việc</th>
                <th>Hạn hoàn thành</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($tasks)): ?>
                <tr><td colspan="4">Chưa có công việc nào.</td></tr>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <?php $overdue = !$task->is_done && strtotime($task->due_date) < time(); ?>
                    <tr>
                        <td class="<?= $task->is_done ? 'done' : '' ?>">
                            <?= htmlspecialchars($task->title) ?>
                            <?php if ($task->description): ?>
                                <br><small><?= htmlspecialchars($task->description) ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="<?= $overdue ? 'overdue' : '' ?>">
                            <?= date('d/m/Y H:i', strtotime($task->due_date)) ?>
                            <?= $overdue ? '(Quá hạn)' : '' ?>
                        </td>
                        <td><?= $task->is_done ? 'Đã xong' : 'Chưa xong' ?></td>
                        <td class="actions">
                            <a href="<?= site_url('tasks/toggle/' . $task->id) ?>">
                                <?= $task->is_done ? 'Bỏ đánh dấu' : 'Hoàn thành' ?>
                            </a>
                            <a href="<?= site_url('tasks/edit/' . $task->id) ?>">Sửa</a>
                            <a href="<?= site_url('tasks/delete/' . $task->id) ?>" onclick="return confirm('Xóa công việc này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
