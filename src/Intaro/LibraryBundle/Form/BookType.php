<?php

namespace Intaro\LibraryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Название'))
            ->add('author', 'text', array('label' => 'Автор'))
            ->add('cover_input', 'file', array('label' => 'Обложка (png, jpg)', 'required' => false))
            ->add('file_input', 'file', array('label' => 'Файл с книгой (до 5мб)', 'required' => false))
            ->add('read_at', 'date', array('label' => 'Дата прочтения', 'widget' => 'single_text'))
            ->add('allow_download', 'checkbox', array('label' => 'Разрешить скачивание', 'required' => false))
            ->add('save', 'submit', array('label' => 'Сохранить'))
            ->add('apply', 'submit', array('label' => 'Применить'))
            ->add('delete', 'submit', array('label' => 'Удалить книгу'));
    }

    public function getName()
    {
        return 'book';
    }
}