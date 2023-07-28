<?php

namespace App\Controller\Back;

use App\Entity\Mentor;
use App\Entity\Mission;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class MentorCrudController extends AbstractCrudController
{

    public function __construct(private EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Mentor::class;
    }

    public function index(AdminContext $context):Response
    {
        $mentors = $this->em->getRepository(Mentor::class)->findAll();
        $mentorsDemands = $this->em->getRepository(Mentor::class)->findBy(['status' => false]);
        $missions = $this->em->getRepository(Mission::class)->findAll();

        $groupedMentors = [];
        foreach ($mentors as $mentor) {
            $fullName = $mentor->getConsultant()->getFirstname() . ' ' . $mentor->getConsultant()->getLastname();
            $groupedMentors[$fullName][] = $mentor;
        }
        $groupedSkills = [];
        foreach ($mentors as $mentor) {
            $skills = $mentor->getConsultant()->getSkills();
            $fullName = $mentor->getConsultant()->getFirstname() . ' ' . $mentor->getConsultant()->getLastname();
            foreach ($skills as $skill) {
                $groupedSkills[$fullName][] = $skills;
            }
        }
        return $this->render('back/mentor/index.html.twig', [
            'groupedMentors' => $groupedMentors,
            'groupedSkills' => $groupedSkills,
            'mentors' => $mentorsDemands,
            'missions' => $missions,
        ]);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Mentors')
            ->setSearchFields(['consultant.firstname', 'consulrant.lastname', 'formation.title'])
            ->overrideTemplate('crud/index', 'back/mentor/index.html.twig')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('consultant.firstname' . 'consultant.lastname', 'Consultant',),
            TextField::new('formation.title'),
        ];
    }

    public function validMentor(AdminContext $context): Response
    {
        $mentor = $context->getEntity()->getInstance();
        $mentor->setStatus(true);
        $this->em->persist($mentor);
        $this->em->flush();

        return $this->redirect($this->container->get(AdminUrlGenerator::class)->setAction(Action::INDEX)->unset(EA::ENTITY_ID)->generateUrl());
    }

    public function refuseMentor(AdminContext $context): Response
    {
        $mentor = $context->getEntity()->getInstance();
        $this->em->remove($mentor);
        $this->em->flush();

        return $this->redirect($this->container->get(AdminUrlGenerator::class)->setAction(Action::INDEX)->unset(EA::ENTITY_ID)->generateUrl());
    }
}
