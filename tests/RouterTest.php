<?php
declare(strict_types=1);

class RouterTest extends TestCase
{
    public function testNotDefinedRouteReturns404(): void
    {
        $this->get('/unknown/path');

        $this->assertEquals(404, $this->response->getStatusCode());
    }

    public function testGetMatricesMultiplicationReturns200(): void
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

        $this->app->instance('App\Models\MatrixMultiplication', $calculator);

        $response = $this->call(
            'GET', '/matrices/multiplication', ['a' => '[1,2]', 'b' => '[1,2]']
        );

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetMatricesMultiplicationReturns400WithInvalidArgs(): void
    {
        Validator::shouldReceive('make')
            ->once()
            ->andThrow('Illuminate\Validation\ValidationException');

        $response = $this->call(
            'GET', '/matrices/multiplication', ['a' => '', 'b' => '']
        );

        $this->assertEquals(400, $response->getStatusCode());
    }
}
