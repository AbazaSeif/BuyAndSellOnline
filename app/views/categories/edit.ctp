<?php

echo $html->tag('h2', 'Categories');

if ($session->flash()) {
    echo $session->flash();
 }

// If category is set, create a form for editing.
// Otherwise show paginated categories.
if (isset($category)) {
    echo $ajax->link('Category list',
		     array('action' => 'edit'),
		     array('update' => 'content'));
    echo $html->para(null, 'Fields marked with bold text are required.');

    // Edit category
    echo $form->create('Category');
    echo $form->input('name',
		      array('label' => array('class' => 'span-4 form',
                             'text' => 'Name:'),
                  'default' => $category['Category']['name']));
    echo $form->input('category',
        array('label' => array('class' => 'span-4 form',
                       'text' => 'Parent:'),
            'empty' => 'None',
            'default' => $category['Category']['category_id']));
    echo $form->label(null, '', array('class' => 'span-4'));
    echo $ajax->submit('Save Category',
        array('url' => array('controller' => 'categories',
                     'action' => 'edit',
                     $category['Category']['id']),
            'update' => 'content'));
    echo $javascript->codeBlock("Form.Element.focus('CategoryName');");
    echo $javascript->blockEnd();
    echo $form->end();
 } else {
    $paginator->options(array('update' => 'content', 'indicator' => 'spinner'));
    echo $html->div('sort', 'Sort: '.
        $paginator->sort('Name', 'name').' '.
        $paginator->sort('Created', 'created').
        $html->div('spinner', $html->image('/img/loading.gif'),
            array('id' => 'spinner', 'style' => 'display:none')));
    // Show list of all categories, with delete links
    $out = '';
    // Create a edit and delete link for each category.
    foreach ($data as $category) {
        $out .=	$html->tag('li',
                $html->tag('span', $category['Category']['name']).
                $ajax->link($html->image('edit.gif',
                        array('alt' => 'Edit',
                            'class' => 'edit')),
                    array('action' => 'edit',
                        'id' => $category['Category']['id']),
                    array('update' => 'content'),
                    null,
                    false).' '.
                $ajax->link($html->image('delete.png',
                        array('alt' => 'Delete',
                            'class' => 'delete')),
                    array('action' => 'delete',
                        'id' => $category['Category']['id']),
                    array('update' => 'content'),
                    'Delete '.$category['Category']['name'].'?',
                    false));
    }
    echo $html->tag('ul', $out, array('class' => 'editList'));

    echo $html->div('paginator',
        $paginator->prev('« Previous').' '.
        $paginator->numbers().' '.
        $paginator->next('Next »').'<br />'.
        $paginator->counter().' ');
 }

?>