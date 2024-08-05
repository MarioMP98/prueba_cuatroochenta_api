<?php

namespace App\Controller;

use App\Service\WineService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WineController extends AbstractController
{
    protected $service;


    public function __construct(WineService $service)
    {
        $this->service = $service;
    }


    public function list(): JsonResponse
    {
        try {

            $wines = $this->service->list();

        } catch (\Exception) {

            return new JsonResponse("The wines couldn't be recovered");
        }

        return new JsonResponse($wines);
    }


    public function create(Request $request): JsonResponse
    {
        try {

            $wine = $this->service->create($request->request->all());

        } catch (\Exception) {

            return new JsonResponse("There was an error while creating the wine");
        }

        return new JsonResponse('New wine created with the id: ' . $wine->getId());
    }


    public function update($id, Request $request): JsonResponse
    {
        try {

            $wine = $this->service->update($id, $request->request->all());

        } catch (\Exception) {

            return new JsonResponse("There was an error while updating the wine");
        }

        if (!$wine) {

            return new JsonResponse('The wine to update couldn\'t be found');
        }

        return new JsonResponse('The wine with the id ' . $wine->getId() . ' was successfully updated');

    }


    public function delete($id): JsonResponse
    {
        try {

            $wine = $this->service->delete($id);

        } catch (\Exception) {

            return new JsonResponse("There was an error while deleting the wine");
        }

        if (!$wine) {

            return new JsonResponse('The wine to delete couldn\'t be found');
        }

        return new JsonResponse('The wine was successfully deleted');
    }
}
