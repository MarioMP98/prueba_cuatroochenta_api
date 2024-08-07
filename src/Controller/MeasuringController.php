<?php

namespace App\Controller;

use App\Entity\Measuring;
use App\Service\MeasuringService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
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


    /**
     * Lists the existing measurings.
     *
     * Retrieves and shows a list of all the measurings in the database, including the wine
     * that was measured and the sensor that was used.
     */
    #[OA\Response(
        response: 200,
        description: 'The list of measurings',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Measuring::class))
        )
    )]
    #[OA\Tag(name: 'measuring_list')]
    public function list(): JsonResponse
    {
        try {

            $measurings = $this->service->list();

        } catch (\Exception) {

            return new JsonResponse("The measurings couldn't be recovered");
        }

        return new JsonResponse($measurings);
    }


    /**
     * Creates a new measuring.
     *
     * Creates a new measuring in the database with the data passed through the request.
     */
    #[OA\Response(
        response: 200,
        description: 'A confirmation message with the new entity\'s id',
        content: new OA\JsonContent(
            type: 'string'
        )
    )]
    #[OA\Parameter(
        name: 'sensor',
        in: 'query',
        description: 'The id of the sensor that was used for the measuring',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'wine',
        in: 'query',
        description: 'The id of the wine that was measured',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'year',
        in: 'query',
        description: 'The year the measuring was done',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'color',
        in: 'query',
        description: 'The coloration of the wine',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'temperature',
        in: 'query',
        description: 'The temperature in celsius the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Parameter(
        name: 'graduation',
        in: 'query',
        description: 'The level of alcoholic graduation the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Parameter(
        name: 'ph',
        in: 'query',
        description: 'The PH level the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Tag(name: 'measuring_create')]
    public function create(Request $request): JsonResponse
    {
        try {

            $measuring = $this->service->create($request->request->all());

        } catch (\Exception) {

            return new JsonResponse("There was an error while creating the measuring");
        }

        return new JsonResponse('New measuring created with the id: ' . $measuring->getId());
    }


    /**
     * Update an existing measuring
     *
     * Updates an existing measuring in the database with the data passed through the request.
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
        description: 'The id of the measuring to update',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'sensor',
        in: 'query',
        description: 'The id of the sensor that was used for the measuring',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'wine',
        in: 'query',
        description: 'The id of the wine that was measured',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'year',
        in: 'query',
        description: 'The year the measuring was done',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'color',
        in: 'query',
        description: 'The coloration of the wine',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'temperature',
        in: 'query',
        description: 'The temperature in celsius the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Parameter(
        name: 'graduation',
        in: 'query',
        description: 'The level of alcoholic graduation the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Parameter(
        name: 'ph',
        in: 'query',
        description: 'The PH level the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Tag(name: 'measuring_update')]
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


    /**
     * Delete an existing measuring
     *
     * Deletes an existing measuring in the database.
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
        description: 'The id of the measuring to delete',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'measuring_delete')]
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
