<?php
declare(strict_types=1);

namespace App\Http\Controllers\Matrix;

use App\Exceptions\InvalidMatrixException;
use App\Http\Controllers\Controller;
use App\Models\MatrixCalculator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MultiplicationController extends Controller
{
    private $request;
    private $calculator;

    public function __construct(Request $request, MatrixCalculator $calculator)
    {
        $this->request = $request;
        $this->calculator = $calculator;
    }

    public function byMatrix(): JsonResponse
    {
        try {
            $matrices = [
                'a' => json_decode($this->request->input('a', '')),
                'b' => json_decode($this->request->input('b', ''))
            ];

            Validator::make($matrices, [
                'a' => 'required|array',
                'b' => 'required|array'
            ])->validate();

            $this->calculator->setValues($matrices['a'], $matrices['b']);
            return new JsonResponse($this->calculator->calculate()->result());

        } catch (ValidationException | InvalidMatrixException $e) {
            return new JsonResponse(['error' => 'Request not valid!'], 400);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
