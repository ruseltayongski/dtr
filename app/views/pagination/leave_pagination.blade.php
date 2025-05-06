<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
$lastPage = $paginator->getLastPage();
$currentPage = $paginator->getCurrentPage();
?>

<?php if ($paginator->getLastPage() > 1): ?>
<ul class="pagination">
    <!-- First Page Link (now points to last page) -->
    <?php if ($currentPage != $lastPage): ?>
    <li><a href="<?php echo $paginator->getUrl($lastPage); ?>">&laquo;</a></li>
    <?php else: ?>
    <li class="disabled"><span>&laquo;</span></li>
    <?php endif; ?>

<!-- Previous Page Link (moves toward page 1) -->
    <?php if ($currentPage < $lastPage): ?>
    <li><a href="<?php echo $paginator->getUrl($currentPage + 1); ?>">&lsaquo;</a></li>
    <?php else: ?>
    <li class="disabled"><span>&lsaquo;</span></li>
    <?php endif; ?>

<!-- Page Number Links in Reverse Order -->
    <?php for($i = $lastPage; $i >= 1; $i--): ?>
    <?php if($currentPage == $i): ?>
    <li class="active"><span><?php echo $i; ?></span></li>
    <?php else: ?>
    <li><a href="<?php echo $paginator->getUrl($i); ?>"><?php echo $i; ?></a></li>
    <?php endif; ?>
    <?php endfor; ?>

<!-- Next Page Link (moves toward page 1) -->
    <?php if ($currentPage > 1): ?>
    <li><a href="<?php echo $paginator->getUrl($currentPage - 1); ?>">&rsaquo;</a></li>
    <?php else: ?>
    <li class="disabled"><span>&rsaquo;</span></li>
    <?php endif; ?>

<!-- Last Page Link (now points to page 1) -->
    <?php if ($currentPage != 1): ?>
    <li><a href="<?php echo $paginator->getUrl(1); ?>">&raquo;</a></li>
    <?php else: ?>
    <li class="disabled"><span>&raquo;</span></li>
    <?php endif; ?>
</ul>
<?php endif; ?>