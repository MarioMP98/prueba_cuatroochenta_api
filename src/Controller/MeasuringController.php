<?php

namespace App\Controller;

use App\Service\MeasuringService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MeasuringController extends AbstractController
{
    protected $service;


    public function __construct(MeasuringService $service)
    {
        $this->service = $service;
    }


    public function list(): JsonResponse
    {
        try {

            $measurings = $this->service->list();

        } catch (\Exception) {

            return new JsonResponse("The measurings couldn't be recovered");
        }

        return new JsonResponse($measurings);
    }


    public function create(Request $request): JsonResponse
    {
        try {

            $measuring = $this->service->create($request->request->all());

        } catch (\Exception) {

            return new JsonResponse("There was an error while creating the measuring");
        }

        return new JsonResponse('New measuring created with the id: ' . $measuring->getId());
    }


    public function update($id, Request $request): JsonResponse
    {
        try {

            $measuring = $this->service->update($id, $request->request->all());

        } catch (\Exception) {

            return new JsonResponse("There was an error while updating the measuring");
        }

        if (!$measuring) {

            return new JsonResponse('The measuring to update couldn\'t be found');
        }

        return new JsonResponse('The measuring with the id ' . $measuring->getId() . ' was successfully updated');

    }


    public function delete($id): JsonResponse
    {
        try {

            $measuring = $this->service->delete($id);

        } catch (\Exception) {

            return new JsonResponse("There was an error while deleting the measuring");
        }

        if (!$measuring) {

            return new JsonResponse('The measuring to delete couldn\'t be found');
        }

        return new JsonResponse('The measuring was successfully deleted');
    }
}
