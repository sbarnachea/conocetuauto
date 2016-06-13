<?php
	echo '<ul class="pagination pull-right">';
	echo $this->Paginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
	echo $this->Paginator->numbers(array(
		'separator' => '',
		'currentClass' => 'active',
		'currentTag' => 'a',
		'tag' => 'li',
		'modulus' => 4
	));
	echo $this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
	echo '</ul>';
?>