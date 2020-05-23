<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 8:36 AM
 */

namespace App\Factory;


use App\Entity\Loan;
use Symfony\Component\Security\Core\Security;

class LoanFactory
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Create default loan
     *
     * @return Loan
     */
    public function createDefaultLoan()
    {
        $loan = new Loan();
        $loan->setUser($this->security->getUser());
        $loan->setStatus(Loan::LOAN_STATUS_NEW);
        $loan->setRepaymentFrequency(Loan::REPAYMENT_WEEKLY);

        return $loan;
    }

    /**
     * Handle business when a loan is approved
     *
     * @param Loan $loan
     */
    public function handleApproveLoan(Loan $loan)
    {
        //Do nothing when application is not approved
        if (!$loan->isApproved()) {
            return;
        }

        //Assign firstRepaymentDate for nextRepaymentDate
        if (!$loan->getNextRepaymentDate()) {
            $loan->setNextRepaymentDate($loan->getFirstRepaymentDate());
            return;
        }
    }
}