<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 29.08.14
 * Time: 9:38
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Currency;
use Matrix\AdminBundle\Entity\Customers;
use Matrix\AdminBundle\Entity\Department;
use Matrix\AdminBundle\Entity\Division;
use Matrix\AdminBundle\Entity\Plant;
use Matrix\AdminBundle\Entity\Products;
use Matrix\AdminBundle\Entity\Services;
use Matrix\AdminBundle\Entity\Statuses;
use Matrix\AdminBundle\Entity\Unit;
use Matrix\AdminBundle\Entity\Users;
use Matrix\AdminBundle\Entity\UserStatus;
use Matrix\AdminBundle\Entity\UserType;
use Matrix\AdminBundle\Entity\Warehouse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerController extends Controller
{

    public function getMobileUsersAction()
    {
        try {
            $mobileUsers = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Users")
                ->findBy(
                    array("type"    => UserType::MOBILE_USER,
                          "company" => $this->getUser()->getCompany())
                );

            return $this->render("MatrixAdminBundle:Manager:mobileUsers.html.twig", array("users" => $mobileUsers));
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createMobileUserFormAction()
    {
        return $this->render("MatrixAdminBundle:Manager:mobileUserForm.html.twig");
    }

    public function createMobileUserAction(Request $request)
    {
        try {
            $name = $request->request->get('m-user-name');
            $surname = $request->request->get('m-user-surname');
            $email = $request->request->get('m-user-email');
            $password = $request->request->get('m-user-password');


            $factory = $this->get('security.encoder_factory');

            $company = $this->getUser()->getCompany();


            $user = new Users();

            $user->setSalt(Users::generateSalt());
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($password, $user->getSalt());

            $user->setPassword($password)
                ->setType(UserType::MOBILE_USER)
                ->setStatus(UserStatus::ACTIVE)
                ->setCompany($company)
                ->setEmail($email)
                ->setName($name)
                ->setSurname($surname)
                ->setCreator($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:createMobileUserForm");
    }

    public function updateMobileUserFormAction($id)
    {
        try {
            $user = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Users")->findOneBy(array("id" => $id));
            $statuses = Statuses::getStatuses();
            return $this->render(
                "MatrixAdminBundle:Manager:mobileUserUpdateForm.html.twig",
                array(
                    "user"     => $user,
                    "statuses" => $statuses)
            );
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );
            return $this->redirect($this->generateUrl("mobile_users_list"));
        }

    }

    public function updateMobileUserAction(Request $request)
    {
        try {
            $name = $request->request->get('m-user-name');
            $surname = $request->request->get('m-user-surname');
            $email = $request->request->get('m-user-email');
            $password = $request->request->get('m-user-password');
            $status = $request->request->get("m-user-status");
            $idMobileUser = $request->request->get("m-user-id");

            $user = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Users")->findOneBy(array("id" => $idMobileUser));

            if (!empty($password)) {
                $factory = $this->get('security.encoder_factory');
                $user->setSalt(Users::generateSalt());
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($password, $user->getSalt());
                $user->setPassword($password);
            }

            $user->setName($name)
                ->setSurname($surname)
                ->setEmail($email)
                ->setStatus($status);

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );
        }
        return $this->redirect($this->generateUrl("mobile_users_list"));
    }


    public function getDepartmentsAction()
    {
        try {
            $departments = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Department")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render(
                "MatrixAdminBundle:Manager:departments.html.twig", array("departments" => $departments)
            );
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createDepartmentFormAction()
    {
        return $this->render("MatrixAdminBundle:Manager:departmentForm.html.twig");
    }

    public function createDepartmentAction(Request $request)
    {
        try {
            $name = $request->request->get('department-name');
            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Department")->findMaxVersion();

            $department = new Department();
            $department->setName($name)
                ->setCompany($company)
                ->setVersion($version);


            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:createDepartmentForm");
    }

    public function updateDepartmentFormAction($id) {
        try {
            $department = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Department")->findOneBy(array("id" => $id));

            return $this->render(
                "MatrixAdminBundle:Manager:departmentUpdateForm.html.twig",
                array(
                    "department"     => $department)
            );
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );
            return $this->redirect($this->generateUrl("departments_list"));
        }
    }

    public function updateDepartmentAction(Request $request) {
        try {
            $nameDep = $request->request->get("department-name");
            $idDep   = $request->request->get("department-id");
            $em = $this->getDoctrine();
            $departmentRepository = $em->getRepository("MatrixAdminBundle:Department");

            $department = $departmentRepository->findOneBy(array("id" => $idDep));
            $version = $departmentRepository->findMaxVersion();

            $department->setName($nameDep)
                ->setVersion($version);
            $em->getManager()->persist($department);
            $em->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );
        }
        catch(Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );
        }
        return $this->redirect($this->generateUrl("departments_list"));
    }


    public function getPlantsAction()
    {
        try {
            $plants = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Plant")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:plants.html.twig", array("plants" => $plants));
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createPlantFormAction()
    {
        return $this->render("MatrixAdminBundle:Manager:plantForm.html.twig");
    }

    public function createPlantAction(Request $request)
    {
        try {
            $name = $request->request->get('plant-name');
            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Plant")->findMaxVersion();

            $plant = new Plant();
            $plant->setName($name)
                ->setCompany($company)
                ->setVersion($version);


            $em = $this->getDoctrine()->getManager();
            $em->persist($plant);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:createPlantForm");
    }

    public function updatePlantFormAction($id) {
        try {
            $plant = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Plant")->findOneBy(array("id" => $id));

            return $this->render(
                "MatrixAdminBundle:Manager:plantUpdateForm.html.twig",
                 array(
                    "plant"  => $plant)
              );
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );
            return $this->redirect($this->generateUrl("plants_list"));
        }
}

    public function updatePlantAction(Request $request)
    {
        try {
            $plantName = $request->request->get('plant-name');
            $plantId = $request->request->get('plant-id');

            $em = $this->getDoctrine();
            $plantRepository = $em->getRepository("MatrixAdminBundle:Plant");

            $plant = $plantRepository->findOneBy(array("id" => $plantId));
            $version = $plantRepository->findMaxVersion();

            $plant->setName($plantName)
                ->setVersion($version);
            $em->getManager()->persist($plant);
            $em->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:getPlants");
    }

    public function getWarehousesAction()
    {
        try {
            $warehouses = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Warehouse")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:warehouses.html.twig", array("warehouses" => $warehouses));
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createWarehouseFormAction()
    {
        return $this->render("MatrixAdminBundle:Manager:warehouseForm.html.twig");
    }

    public function createWarehouseAction(Request $request)
    {
        try {
            $name = $request->request->get('warehouse-name');
            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Warehouse")->findMaxVersion();

            $warehouse = new Warehouse();
            $warehouse->setName($name)
                ->setCompany($company)
                ->setVersion($version);


            $em = $this->getDoctrine()->getManager();
            $em->persist($warehouse);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:createWarehouseForm");
    }

    public function getDivisionsAction()
    {
        try {
            $divisions = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Division")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:divisions.html.twig", array("divisions" => $divisions));
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createDivisionFormAction()
    {
        return $this->render("MatrixAdminBundle:Manager:divisionForm.html.twig");
    }

    public function createDivisionAction(Request $request)
    {
        try {
            $name = $request->request->get('division-name');
            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Division")->findMaxVersion();

            $division = new Division();
            $division->setName($name)
                ->setCompany($company)
                ->setVersion($version);


            $em = $this->getDoctrine()->getManager();
            $em->persist($division);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:createDivisionForm");
    }

    public function getCurrenciesAction()
    {
        try {
            $currencies = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Currency")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:currencies.html.twig", array("currencies" => $currencies));
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createCurrencyFormAction()
    {
        return $this->render("MatrixAdminBundle:Manager:currencyForm.html.twig");
    }

    public function createCurrencyAction(Request $request)
    {
        try {
            $name = $request->request->get('currency-name');
            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Currency")->findMaxVersion();

            $currency = new Currency();
            $currency->setName($name)
                ->setCompany($company)
                ->setVersion($version)
                ->setStatus(Statuses::ACTIVE);


            $em = $this->getDoctrine()->getManager();
            $em->persist($currency);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:createCurrencyForm");
    }

    public function getCustomersAction()
    {
        try {
            $customers = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Customers")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:customers.html.twig", array("customers" => $customers));
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createCustomerFormAction()
    {
        return $this->render("MatrixAdminBundle:Manager:customerForm.html.twig");
    }

    public function createCustomerAction(Request $request)
    {
        try {
            $name = $request->request->get('customer-name');
            $longitude = $request->request->get('customer-longitude');
            $latitude = $request->request->get('customer-latitude');

            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Customers")->findMaxVersion();

            $customer = new Customers();
            $customer->setName($name)
                ->setCompany($company)
                ->setVersion($version)
                ->setStatus(Statuses::ACTIVE)
                ->setLatitude($latitude)
                ->setLongitude($longitude);


            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:createCustomerForm");
    }

    public function getUnitsAction()
    {
        try {
            $units = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Unit")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:units.html.twig", array("units" => $units));
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createUnitFormAction()
    {
        return $this->render("MatrixAdminBundle:Manager:unitForm.html.twig");
    }

    public function createUnitAction(Request $request)
    {
        try {
            $name = $request->request->get('unit-name');

            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Unit")->findMaxVersion();

            $unit = new Unit();
            $unit->setName($name)
                ->setCompany($company)
                ->setVersion($version)
                ->setStatus(Statuses::ACTIVE);


            $em = $this->getDoctrine()->getManager();
            $em->persist($unit);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:createUnitForm");
    }

    public function getProductsAction()
    {
        try {
            $products = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Products")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:products.html.twig", array("products" => $products));
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createProductFormAction()
    {
        $units = $this->getDoctrine()
            ->getRepository("MatrixAdminBundle:Unit")
            ->findBy(
                array("status"  => Statuses::ACTIVE,
                      "company" => $this->getUser()->getCompany())
            );
        return $this->render("MatrixAdminBundle:Manager:productForm.html.twig", array("units" => $units));
    }

    public function createProductAction(Request $request)
    {
        try {
            $name = $request->request->get('product-name');
            $quantity = $request->request->get('product-quantity');
            $description = $request->request->get('product-description');
            $vat = $request->request->get('product-vat');
            $code = $request->request->get('product-code');
            $unitId = $request->request->get("product-unit");

            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Products")->findMaxVersion();
            $unit = $this->getDoctrine()->getRepository("MatrixAdminBundle:Unit")->findOneBy(array("id" => $unitId));

            $product = new Products();
            $product->setName($name)
                ->setQuantity($quantity)
                ->setDescription($description)
                ->setVat($vat)
                ->setUnit($unit)
                ->setCompany($company)
                ->setVersion($version)
                ->setStatus(Statuses::ACTIVE)
                ->setCode($code);


            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:createProductForm");
    }

    public function getServicesAction()
    {
        try {
            $services = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Services")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:services.html.twig", array("services" => $services));
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createServiceFormAction()
    {
        $units = $this->getDoctrine()
            ->getRepository("MatrixAdminBundle:Unit")
            ->findBy(
                array("status"  => Statuses::ACTIVE,
                      "company" => $this->getUser()->getCompany())
            );
        return $this->render("MatrixAdminBundle:Manager:serviceForm.html.twig", array("units" => $units));
    }

    public function createServiceAction(Request $request)
    {
        try {
            $name = $request->request->get('service-name');
//            $quantity = $request->request->get('service-quantity');
            $description = $request->request->get('service-description');
            $vat = $request->request->get('service-vat');
            $code = $request->request->get('service-code');
            $unitId = $request->request->get("service-unit");

            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Services")->findMaxVersion();
            $unit = $this->getDoctrine()->getRepository("MatrixAdminBundle:Unit")->findOneBy(array("id" => $unitId));

            $service = new Services();
            $service->setName($name)
                ->setDescription($description)
                ->setVat($vat)
                ->setUnit($unit)
                ->setCompany($company)
                ->setVersion($version)
                ->setStatus(Statuses::ACTIVE)
                ->setCode($code);


            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:createServiceForm");
    }

    public function updateServiceFormAction($id)
    {
        try {
            $units = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Unit")
                ->findBy(
                    array("status"  => Statuses::ACTIVE,
                          "company" => $this->getUser()->getCompany())
                );

            $service = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Services")
                ->findOneBy(
                    array("id"      => $id,
                          "company" => $this->getUser()->getCompany())
                );

            return $this->render(
                "MatrixAdminBundle:Manager:updateServiceForm.html.twig",
                array("units" => $units, "service" => $service)
            );
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->redirect($this->generateUrl("services_list"));
        }
    }

    public function updateServiceAction(Request $request)
    {
        try {

            $id = $request->request->get('service-id');
            $name = $request->request->get('service-name');

            $description = $request->request->get('service-description');
            $vat = $request->request->get('service-vat');
            $code = $request->request->get('service-code');
            $unitId = $request->request->get("service-unit");

            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Services")->findMaxVersion();
            $unit = $this->getDoctrine()->getRepository("MatrixAdminBundle:Unit")->findOneBy(array("id" => $unitId));

            $service = $this->getDoctrine()->getRepository("MatrixAdminBundle:Services")->findOneBy(array("id" => $id));
            $service->setName($name)
                ->setDescription($description)
                ->setVat($vat)
                ->setUnit($unit)
                ->setVersion($version)
                ->setCode($code);


            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Manager:getServices");
    }
} 