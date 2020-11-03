

<table>
    <?php foreach ($teachers as $teacher): ?>
        <tr>
            <td>
                <a href="index.php?teacher=<?php echo $teacher["id"]; ?>"
                   class="text-light"><?php echo $teacher["name"]; ?></a>
            </td>
            <td>
                <?php echo $teacher["email"]; ?>
            </td>
        </tr>
        <td>
            <form method="post">
                <input type="hidden" name="idupdate" value="<?php echo $teacher['id']?>" />
                <input type="submit" name="update" value="Update" class="btn btn-sucess">
            </form>
        </td>
        <td>
            <a href="?delete=<?php echo $teacher['id']?>" class="btn btn-danger">Delete</a>
        </td>
    <?php endforeach; ?>

</table>
