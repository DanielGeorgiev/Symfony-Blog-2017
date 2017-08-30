<?php

namespace CalculatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use CalculatorBundle\Entity\Calculator;
use CalculatorBundle\Form\CalculatorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CalculatorController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/", name="index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function index(Request $request)
    {
        $calculator = new Calculator();

        $form = $this->createForm(CalculatorType::class, $calculator);

        $form->handleRequest($request);

        $result = 0;

        if ($form->isSubmitted() && $form->isValid()) {
            $operator = $calculator->getOperator();
            $leftOperand = $calculator->getLeftOperand();
            $rightOperand = $calculator->getRightOperand();

            switch ($operator) {
                case "+":
                    $result = $leftOperand + $rightOperand;
                    break;

                case "-":
                    $result = $leftOperand - $rightOperand;
                    break;

                case "*":
                    $result = $leftOperand * $rightOperand;
                    break;
                case "/":
                    $result = ($rightOperand != 0) ? $leftOperand / $rightOperand : "NaN";
                    break;
                case"^":
                    $result = pow($leftOperand, $rightOperand);
                    break;
                case">":
                    $result = ($leftOperand > $rightOperand) ? "TRUE" : "FALSE";
                    break;
                case"<":
                    $result = ($leftOperand < $rightOperand) ? "TRUE" : "FALSE";
                    break;
                case"=":
                    $result = ($rightOperand === $leftOperand) ? "TRUE" : "FALSE";
                    break;
            }

            return $this->render('calculator/index.html.twig',
                ['result' => $result, 'calculator' => $calculator, 'form' => $form->createView()]);
        }

        return $this->render('calculator/index.html.twig', ['form' => $form->createView()]);
    }
}
