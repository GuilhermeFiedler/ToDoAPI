<?php
declare(strict_types=1);

use InvalidArgumentException;
use JsonException;
use Throwable;

class  Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, callable $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, callable $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($path, PHP_URL_PATH);

        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = preg_replace('/\{(\w+)}/', '(?P<$1>[^/]+)', $route);

            if (preg_match("#^{$pattern}$#", $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                try {
                    $response = $handler($params);

                    if ($response === null){
                        http_response_code(204);
                        return;
                    }

                    echo json_encode($response, JSON_THROW_ON_ERROR);
                    return;

                } catch (InvalidArgumentException $e) {
                    http_response_code(422);
                    echo json_encode(['erro' => $e->getMessage()]);
                    return;

                } catch (JsonException $e) {
                    http_response_code(500);
                    echo json_encode(['erro' => 'Erro ao gerar JSON']);
                    return;

                } catch (Throwable $e) {
                    http_response_code(500);
                    echo json_encode(['erro' => 'Erro interno']);
                    return;
                }
            }
        }

        http_response_code(404);
        echo json_encode(['erro' => 'Rota não encontrada']);
    }
}