<?php

namespace App\Http\Controllers\Transaction;

use App\Exceptions\ErrorResponse;
use App\Handler\Response\Response;
use App\Handler\Response\ResponseMessage;
use App\Handler\Response\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Repositories\Transaction\InvoiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Transaction\Configurator\InvoiceConfigurator;
use Throwable;

class InvoiceController extends Controller
{
    protected InvoiceRepository $repository;
    protected Response $response;

    public function __construct(InvoiceRepository $repository, Response $response)
    {
        $this->repository = $repository;
        $this->response = $response;
    }

    public function index(Request $request): array
    {

        $this->validateRequest(
            $request,
            InvoiceConfigurator::ALLOWED_QUERY_PARAMS,
            InvoiceConfigurator::RULES_QUERIES
        );
        $this->validatePermission(InvoiceConfigurator::PERMISSION_INDEX);
        try {
            $data = $this->repository->getAll($request);
            return $this->response->setPaginationData($data)
                ->setMessage(ResponseMessage::GetDefaultMessage($data->total()))
                ->setStatus(ResponseStatus::GET_STATUS)
                ->setMeta(
                    #---------------------------------#
                    # @Nakamacode                     #
                    #---------------------------------#
                    # Here for Another Meta Data      #
                    #---------------------------------#
                )->get();
        } catch (Throwable $e) {
            throw new ErrorResponse($e->getMessage());
        }
    }

    public function show(int $id): array
    {

        try {

            $this->validatePermission(InvoiceConfigurator::PERMISSION_SHOW);
            $data = $this->repository->getById($id);
            return $this->response->setData($data)
                ->setStatus(ResponseStatus::GET_STATUS)
                ->setMessage(ResponseMessage::SHOW_DEFAULT_MESSAGE)
                ->setMeta(
                    #--------------------------------- #
                    # @Nakamacode                      #
                    #--------------------------------- #
                    # Here for Another Meta Data Array #
                    #--------------------------------- #
                )->get();
        } catch (Throwable $e) {
            throw new ErrorResponse($e->getMessage());
        }
    }

    public function store(Request $request): array
    {

        $this->validatePermission(InvoiceConfigurator::PERMISSION_STORE);
        $this->validateRequest(
            $request,
            InvoiceConfigurator::ALLOWED_REQUEST_FIELDS,
            InvoiceConfigurator::RULES_BODY_COMMON
        );

        try {
            $data = $this->repository->create($request);
            return $this->response->setData($data)
                ->setStatus(ResponseStatus::CREATED_STATUS)
                ->setMessage(ResponseMessage::CREATED_DEFAULT_MESSAGE)
                ->setMeta(
                    #--------------------------------- #
                    # @Nakamacode                      #
                    #--------------------------------- #
                    # Here for Another Meta Data Array #
                    #--------------------------------- #
                )->get();
        } catch (Throwable $e) {
            throw new ErrorResponse($e->getMessage());
        }
    }


    public function update(Request $request, int $id): array
    {

        $this->validatePermission(InvoiceConfigurator::PERMISSION_UPDATE);
        $this->validateRequest($request, InvoiceConfigurator::ALLOWED_REQUEST_FIELDS, InvoiceConfigurator::RULES_BODY_COMMON);
        try {
            $data = $this->repository->update($id, $request);
            return $this->response->setData($data)
                ->setStatus(ResponseStatus::PUT_STATUS_WITH_DATA)
                ->setMessage(ResponseMessage::UPDATED_DEFAULT_MESSAGE)
                ->setMeta(
                    #--------------------------------- #
                    # @Nakamacode                      #
                    #--------------------------------- #
                    # Here for Another Meta Data Array #
                    #--------------------------------- #
                )->get();
        } catch (Throwable $e) {
            throw new ErrorResponse($e->getMessage());
        }
    }

    public function destroy(int $id)
    {

        $this->validatePermission(InvoiceConfigurator::PERMISSION_DESTROY);
        $this->repository->delete($id);
        try {
            return $this->response->setData()
                ->setStatus(ResponseStatus::DELETE_STATUS)
                ->setMessage(ResponseMessage::DELETED_DEFAULT_MESSAGE)
                ->setMeta(
                    #--------------------------------- #
                    # @Nakamacode                      #
                    #--------------------------------- #
                    # Here for Another Meta Data Array #
                    #--------------------------------- #
                )->get();
        } catch (Throwable $e) {
            throw new ErrorResponse($e->getMessage());
        }
    }
}
