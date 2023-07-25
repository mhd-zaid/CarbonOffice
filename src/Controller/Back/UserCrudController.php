<?php

namespace App\Controller\Back;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
class UserCrudController extends AbstractCrudController
{
    
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Details'),
            TextField::new('lastname'),
            TextField::new('firstname'),
            TextField::new('email')->onlyOnForms(),
            TextField::new('plainPassword')->onlyOnForms(),
            IntegerField::new('age'),
            FormField::addTab('Address')->onlyOnForms(),
            TextField::new('phone')->onlyOnForms(),
            TextField::new('address')->onlyOnForms(),
            TextField::new('city')->onlyOnForms(),
            NumberField::new('zipCode')->onlyOnForms(),
        ];
    }
}
