<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Service\WineService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
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


    /**
     * Lists the existing wines.
     *
     * Retrieves and shows a list of all the wines in the database, including all of their measurings.
     */
    #[OA\Response(
        response: 200,
        description: 'The list of wines',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Wine::class))
        )
    )]
    #[OA\Tag(name: 'wine_list')]
    public function list(): JsonResponse
    {
        try {

            $wines = $this->service->list();

        } catch (\Exception) {

            return new JsonResponse("The wines couldn't be recovered");
        }

        return new JsonResponse($wines);
    }


    /**
     * Creates a new wine.
     *
     * Creates a new wine in the database with the data passed through the request.
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
        description: 'A name to assign to the wine',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'year',
        in: 'query',
        description: 'The year the wine was made',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Tag(name: 'wine_create')]
    public function create(Request $request): JsonResponse
    {
        try {

            $wine = $this->service->create($request->request->all());

        } catch (\Exception) {

            return new JsonResponse("There was an error while creating the wine");
        }

        return new JsonResponse('New wine created with the id: ' . $wine->getId());
    }


    /**
     * Update an existing wine
     *
     * Updates an existing wine in the database with the data passed through the request.
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
        description: 'The id of the wine to update',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        description: 'A name to assign to the wine',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'year',
        in: 'query',
        description: 'The year the wine was made',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Tag(name: 'wine_update')]
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


    /**
     * Delete an existing wine
     *
     * Deletes an existing wine in the database.
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
        description: 'The id of the wine to delete',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'wine_delete')]
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
