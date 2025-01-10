<?php 
require_once __DIR__ . '/../.././components/sidebar.php';
require_once __DIR__ . '/../../../controllers/CheckoutController.php';

$checkoutController = new CheckoutController();
$checkouts = $checkoutController->index(); // Using the new getCheckout method
?>

<link rel="stylesheet" href="/admin/assets/css/dashboard/dashboard.css">

<div class="page">
    <div class="container">
        <h2>Daftar Checkout</h2>
        
        <table id="checkoutTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Transfer Proof</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php if ($checkouts && mysqli_num_rows($checkouts) > 0) : ?>
        <?php while ($checkout = mysqli_fetch_assoc($checkouts)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($checkout['id'] ?? 'N/A'); ?></td>
               
                <td><?php echo htmlspecialchars($checkout['email'] ?? 'N/A'); ?></td>
                <td>
                    <select onchange="updateStatus(<?php echo $checkout['id']; ?>, this.value)" class="status-select">
                        <option value="pending" <?php echo ($checkout['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="complete" <?php echo ($checkout['status'] == 'complete') ? 'selected' : ''; ?>>Complete</option>
                 
                    </select>
                </td>
                <td>
                    <?php if ($checkout['transfer_proof']) : ?>
                        <a href="<?php echo htmlspecialchars($checkout['transfer_proof']); ?>" target="_blank">View Proof</a>
                    <?php else : ?>
                        No proof uploaded
                    <?php endif; ?>
                </td>
                <td><?php echo date('d/m/Y H:i', strtotime($checkout['created_at'])); ?></td>
                <td>
                    <button onclick="deleteCheckout(<?php echo $checkout['id']; ?>)" class="action-btn">Delete</button>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else : ?>
        <tr>
            <td colspan="9">No checkout data available.</td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#checkoutTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "lengthMenu": [5, 10, 15],
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "language": {
                "lengthMenu": "Show _MENU_ entries per page",
                "zeroRecords": "No data found",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No data available",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "search": "Search:",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
    });

    function updateStatus(id, status) {
        if (confirm('Are you sure you want to update this status?')) {
            $.ajax({
                url: 'update_checkout.php',
                type: 'POST',
                data: { 
                    id: id,
                    status: status
                },
                success: function(response) {
                    alert('Status updated successfully!');
                },
                error: function() {
                    alert('Failed to update status!');
                }
            });
        }
    }

    function viewDetails(id) {
        window.location.href = 'view.php?id=' + id;
    }

    function deleteCheckout(id) {
    if (confirm('Are you sure you want to delete this checkout?')) {
        $.ajax({
            url: 'delete.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                try {
                    let result = JSON.parse(response);
                    if (result.success) {
                        alert(result.message);
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    alert('Unexpected error occurred.');
                }
            },
            error: function() {
                alert('Failed to delete checkout!');
            }
        });
    }
}

</script>