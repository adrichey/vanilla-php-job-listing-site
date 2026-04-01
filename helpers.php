<?php

/**
 * Get the base path
 * 
 * @param string $path
 * @return string
 */
function basePath(string $path = ''): string {
    return __DIR__ . '/' . $path;
}

/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */
function loadView(string $name, array $data = []) {
    $viewPath = basePath("App/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View {$viewPath} not found";
    }
}

/**
 * Load a partial
 * 
 * @param string $name
 * @return void
 */
function loadPartial(string $name, array $data = []) {
    $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        extract($data);
        require $partialPath;
    } else {
        echo "Partial {$partialPath} not found";
    }
}

/**
 * Inspect a variable and optionally die
 * 
 * @param mixed $variable
 * @param bool $die Dies after the variable is dumped
 * @return void
 */
function inspect(mixed $variable, bool $die = false) {
    echo '<pre>' . var_dump($variable) . '</pre>';

    if ($die) {
        die();
    }
}

function formatCurrency(int $amountInCents): string {
    $amount = $amountInCents / 100;
    $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

    $formattedAmount = $formatter->formatCurrency($amount, 'USD');

    if ($formattedAmount === false) {
        return $amount;
    }

    if (str_ends_with($formattedAmount, '.00')) {
        return substr($formattedAmount, 0, -3);
    }

    return $formattedAmount;
}
