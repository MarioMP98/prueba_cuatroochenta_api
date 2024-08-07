<?php

namespace App\Controller;

use App\Entity\Sensor;
use App\Service\SensorService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SensorController extends AbstractController
{
    protected $service;


    public function __construct(SensorService $service)
    {
        $this->service = $service;
    }


    /**
     * Lists the existing sensors.
     *
     * Retrieves and shows a list of all the sensors in the database, ordered alphabetically by name.
     */
    #[OA\Response(
        response: 200,
        description: 'The list of sensors',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Sensor::class))
        )
    )]
    #[OA\Tag(name: 'sensor_list')]
    public function list(): JsonResponse
    {
        try {

            $sensor = $this->service->list();

        } catch (\Exception) {

            return new JsonResponse("The sensors couldn't be recovered");
        }

        return new JsonResponse($sensor);
    }


    /**
     * Creates a new sensor.
     *
     * Creates a new sensor in the database with the data passed through the request.
     */
    #[OA\Response(
        response: 200,
        description: 'A confirmation message with the new entity\'s id',
        content: new OA\JsonContent(
            type: 'string'
        )
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        description: 'A name to assign to the sensor',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'sensor_create')]
    public function create(Request $request): JsonResponse
    {
        try {

            $sensor = $this->service->create($request->request->all());

        } catch (\Exception) {

            return new JsonResponse("There was an error while creating the sensor");
        }

        return new JsonResponse('New sensor created with the id: ' . $sensor->getId());
    }


    /**
     * Update an existing sensor
     *
     * Updates an existing sensor in the database with the data passed through the request.
     */
    #[OA\Response(
        response: 200,
        description: 'A confirmation message with the updated entity\'s id',
        content: new OA\JsonContent(
            type: 'string'
        )
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        description: 'The id of the sensor to update',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        description: 'A name to assign to the sensor',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'sensor_update')]
    public function update($id, Request $request): JsonResponse
    {
        try {

            $sensor = $this->service->update($id, $request->request->all());

        } catch (\Exception) {

            return new JsonResponse("There was an error while updating the sensor");
        }

        if (!$sensor) {

            return new JsonResponse('The sensor to update couldn\'t be found');
        }

        return new JsonResponse('The sensor with the id ' . $sensor->getId() . ' was successfully updated');

    }


    /**
     * Delete an existing sensor
     *
     * Deletes an existing sensor in the database.
     */
    #[OA\Response(
        response: 200,
        description: 'A confirmation message that the entity was successfully deleted',
        content: new OA\JsonContent(
            type: 'string'
        )
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        description: 'The id of the sensor to delete',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'sensor_delete')]
    public function delete($id): JsonResponse
    {
        try {

            $sensor = $this->service->delete($id);

        } catch (\Exception) {

            return new JsonResponse("There was an error while deleting the sensor");
        }

        if (!$sensor) {

            return new JsonResponse('The sensor to delete couldn\'t be found');
        }

        return new JsonResponse('The sensor was successfully deleted');
    }
}
