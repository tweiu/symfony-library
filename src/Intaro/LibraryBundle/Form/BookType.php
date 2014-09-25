<?php

namespace Intaro\LibraryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Title'))
            ->add('author', 'text', array('label' => 'Author'))
            ->add('coverInput', 'file', array('label' => 'Cover', 'required' => false));
        if ($options["data"]->getId() && $options["data"]->getCover()) {
            $builder->add('coverDel', 'checkbox', array('label' => 'Delete cover', 'required' => false));
        }
        $builder
            ->add('fileInput', 'file', array('label' => 'File (up to 5 MB)', 'required' => false));
        if ($options["data"]->getId() && $options["data"]->getFile()) {
            $builder->add('fileDel', 'checkbox', array('label' => 'Delete file', 'required' => false));
        }
        $builder
            ->add('readAt', 'date', array('label' => 'Date of reading', 'widget' => 'single_text'))
            ->add('allowDownload', 'checkbox', array('label' => 'Allow download', 'required' => false))
            ->add('save', 'submit', array('label' => 'Save'))
            ->add('apply', 'submit', array('label' => 'Apply'));
        if ($options["data"]->getId()) {
            $builder->add('delete', 'submit', array('label' => 'Delete book'));
        }
    }

    public function getName()
    {
        return 'book';
    }
}
