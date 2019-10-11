<?php
declare(strict_types=1);

class MultiplicationControllerTest extends TestCase
{
    public function testByMatrixReturnsOk(): void
    {
        Validator::shouldReceive('make')
            ->once()
            ->andReturn(Mockery::mock(['validate' => []]));

        $calculator = $this->getMockBuilder('App\Models\MatrixCalculator')
            ->disableOriginalConstructor()
            ->getMock();

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['result'])
            ->getMock();

        $object->expects($this->once())
            ->method('result')
            ->willReturn('some value');

        $calculator->expects($this->once())
            ->method('calculate')
            ->willReturn($object);

        $calculator->expects($this->once())
            ->method('setValues')
            ->with([1,2], [1,2]);

        $request = $this->getMockBuilder('\Illuminate\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->at(0))
            ->method('input')
            ->with('a')
            ->willReturn('[1,2]');

        $request->expects($this->at(1))
            ->method('input')
            ->with('b')
            ->willReturn('[1,2]');

        $controller = new \App\Http\Controllers\Matrix\MultiplicationController($request, $calculator);
        $response = $controller->byMatrix();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('"some value"', $response->getContent());
    }

    public function testByMatrixReturns400WithInvalidArgs(): void
    {
        Validator::shouldReceive('make')
            ->once()
            ->andThrow('Illuminate\Validation\ValidationException');

        $request = $this->getMockBuilder('\Illuminate\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->at(0))
            ->method('input')
            ->with('a')
            ->willReturn('');

        $request->expects($this->at(1))
            ->method('input')
            ->with('b')
            ->willReturn('');

        $calculator = $this->getMockBuilder('App\Models\MatrixCalculator')
            ->disableOriginalConstructor()
            ->getMock();

        $controller = new \App\Http\Controllers\Matrix\MultiplicationController($request, $calculator);
        $response = $controller->byMatrix();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('{"error":"Request not valid!"}', $response->getContent());
    }

    public function testByMatrixReturns400WithInvalidMatrix(): void
    {
        Validator::shouldReceive('make')
            ->once()
            ->andReturn(Mockery::mock(['validate' => []]));

        $calculator = $this->getMockBuilder('App\Models\MatrixCalculator')
            ->disableOriginalConstructor()
            ->getMock();

        $calculator->expects($this->once())
            ->method('calculate')
            ->willThrowException(new \App\Exceptions\InvalidMatrixException());

        $calculator->expects($this->once())
            ->method('setValues')
            ->with([1,2], [1,2]);

        $request = $this->getMockBuilder('\Illuminate\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->at(0))
            ->method('input')
            ->with('a')
            ->willReturn('[1,2]');

        $request->expects($this->at(1))
            ->method('input')
            ->with('b')
            ->willReturn('[1,2]');

        $controller = new \App\Http\Controllers\Matrix\MultiplicationController($request, $calculator);
        $response = $controller->byMatrix();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('{"error":"Request not valid!"}', $response->getContent());
    }

    public function testByMatrixReturns400WithGenericException(): void
    {
        Validator::shouldReceive('make')
            ->once()
            ->andReturn(Mockery::mock(['validate' => []]));

        $calculator = $this->getMockBuilder('App\Models\MatrixCalculator')
            ->disableOriginalConstructor()
            ->getMock();

        $calculator->expects($this->once())
            ->method('calculate')
            ->willThrowException(new \Exception("Something went wrong"));

        $calculator->expects($this->once())
            ->method('setValues')
            ->with([1,2], [1,2]);

        $request = $this->getMockBuilder('\Illuminate\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->at(0))
            ->method('input')
            ->with('a')
            ->willReturn('[1,2]');

        $request->expects($this->at(1))
            ->method('input')
            ->with('b')
            ->willReturn('[1,2]');

        $controller = new \App\Http\Controllers\Matrix\MultiplicationController($request, $calculator);
        $response = $controller->byMatrix();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('{"error":"Something went wrong"}', $response->getContent());
    }
}
