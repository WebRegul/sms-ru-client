<?php

declare(strict_types=1);

namespace WebRegul\SmsRu;

trait Parameterizable
{
    /**
     * @param array $parameters
     */
    protected function fillFromParameters(array $parameters = []): void
    {
        foreach ($parameters as $property => $value) {
            if (!\property_exists($this, $camel = $this->toCamel($property))) {
                throw new \RuntimeException(\sprintf('Property %s for class %s doesn\'t exists', $property, \get_class($this)));
            }

            $this->$camel = $value;
        }
    }

    /**
     * @param string $property
     *
     * @return string
     */
    private function toCamel(string $property): string
    {
        $property = \ucwords(\str_replace(['-', '_'], ' ', $property));

        return \lcfirst(\str_replace(' ', '', $property));
    }
}
