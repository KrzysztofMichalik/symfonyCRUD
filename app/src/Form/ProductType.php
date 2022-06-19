<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $product = $options['data'];
        $year = ($product->getExpireDate() !== null && $product->getExpireDate()->format('Y') !== null) ? $product->getExpireDate()->format('Y') : date('Y');
        $month = ($product->getExpireDate() !== null && $product->getExpireDate()->format('m') !== null) ? $product->getExpireDate()->format('m') : date('m');
        $day = ($product->getExpireDate() !== null && $product->getExpireDate()->format('d') !== null) ? $product->getExpireDate()->format('d'): date('d');
        $builder
            ->add('expireDate', DateType::class, [
                'years' => range($year, $year+100),
                'months' => range($month, 12),
                'days' => range($day, 31),
                'input_format' => 'Y-m-d',
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('price', IntegerType::class, [
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
