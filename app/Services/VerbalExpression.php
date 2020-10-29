<?php


namespace App\Services;


class VerbalExpression
{

    protected $start;
    protected $end;
    protected $regex;

    public function startOfLine(bool $start = true): VerbalExpression
    {
        $this->start = $start ? '^' : '';
        return $this;
    }

    public function endOfLine(bool $end = true) : VerbalExpression
    {
        $this->end = $end ? '$' : '';
        return $this;
    }

    public function then(string $expression) : VerbalExpression
    {
        $this->regex .= $this->sanitize($expression);
        return $this;
    }

    public function maybe(string $expression) : VerbalExpression
    {
        $this->regex .= '(?:'.$this->sanitize($expression).')?';
        return $this;
    }

    public function anythingBut(string $expression) : VerbalExpression{

        return $this->add('(?:[^' . $this->sanitize($expression) . ']*)?');
    }

    private function add($value)
    {
        $this->regex .= $value;
        return $this;
    }

    public function getRegex(){
        return  '/'.$this->start . $this->regex . $this->end.'/';
    }

    public function test(string $expression) :bool
    {
        return preg_match($this->getRegex(),$expression);
    }

    private function sanitize(string $expression)
    {
        return $expression ? preg_quote($expression, '/') : $expression;
    }
}
