<?php
declare(strict_types=1);

namespace Gfiedler\ToDoAPI\Http;
use InvalidArgumentException;
use JsonException;
use Throwable;
use Gfiedler\ToDoAPI\Exception\ValidationException;
use Gfiedler\ToDoAPI\Exception\NotFoundException;
class Router
{
    private array $routes = [];

    public function get(string $path, callable $h): void
    {
        $this->routes['GET'][$path] = $h;
    }

    public function post(string $path, callable $h): void
    {
        $this->routes['POST'][$path] = $h;
    }

    public function put(string $path, callable $h): void
    {
        $this->routes['PUT'][$path] = $h;
    }

    public function delete(string $path, callable $h): void
    {
        $this->routes['DELETE'][$path] = $h;
    }

    public function dispatch(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = preg_replace('/\{(\w+)}/', '(?P<$1>[^/]+)', $route);
            if (preg_match("#^{$pattern}$#", $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                try {
                    $response = $handler($params);
                    if ($response === null) {
                        http_response_code(204);
                        return;
                    }
                    echo json_encode($response, JSON_THROW_ON_ERROR);
                } catch (ValidationException $e) {
                    http_response_code(422);
                    echo json_encode(['erro' => $e->getMessage(), 'detalhes' => $e->getErrors()]);
                } catch (InvalidArgumentException $e) {
                    http_response_code(422);
                    echo json_encode(['erro' => $e->getMessage()]);
                } catch (NotFoundException $e) {
                    http_response_code(404);
                    echo json_encode(['erro' => $e->getMessage()]);
                } catch (JsonException) {
                    http_response_code(500);
                    echo json_encode(['erro' => 'Erro ao gerar JSON']);
                } catch (Throwable) {
                    http_response_code(500);
                    echo json_encode(['erro' => 'Erro interno']);
                }
                return;
            }
        }
        http_response_code(404);
        echo json_encode(['erro' => 'Rota não encontrada']);
    }
}