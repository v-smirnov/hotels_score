<?php

namespace App\Controller;

use App\Domain\Hotel\HotelScoreServiceInterface;
use App\Dto\HotelScore\HotelScoreRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HotelScoreController extends AbstractController
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var HotelScoreServiceInterface
     */
    private $hotelScoreService;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        ValidatorInterface $validator,
        HotelScoreServiceInterface $hotelScoreService,
        SerializerInterface $serializer
    ) {
        $this->validator = $validator;
        $this->hotelScoreService = $hotelScoreService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/hotels/{hotelId}/score/from/{startDateTime}/to/{endDateTime}", name="hotels_score")
     */
    public function index(Request $request): Response
    {
        $requestObject = HotelScoreRequest::createFromHttpRequest($request);

        $errors = $this->validator->validate($requestObject);

        if ($errors->count() > 0) {
            return new JsonResponse('Request contains invalid data', Response::HTTP_BAD_REQUEST);
        }

        return
            new Response(
                $this->serializer->serialize($this->hotelScoreService->getHotelScoreList($requestObject), 'json'),
                Response::HTTP_OK,
                ['Content-Type' => 'application/json']
            );
    }
}
