<h2>Library Inventory</h2>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Available</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($books)): ?>
            <tr>
                <td colspan="4">No books found in the library.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                    <td><?php echo htmlspecialchars($book['available_copies']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<br>
<a href="index.php?action=home">Back to Home</a>