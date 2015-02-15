<?php

namespace spec\Workly\Domain\Model\User;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Workly\Domain\Model\Company\Company;
use Workly\Domain\Model\Quality\Quality;
use Workly\Domain\Model\Skill;
use Workly\Domain\Model\User\Education;
use Workly\Domain\Model\User\Email;
use Workly\Domain\Model\User\Employment;
use Workly\Domain\Model\User\HashedPassword;
use Workly\Domain\Model\User\Name;
use Workly\Domain\Model\UuidIdentity;

class UserSpec extends ObjectBehavior
{
    function let(UuidIdentity $id, Name $name, Email $email, HashedPassword $password)
    {
        $this->beConstructedThrough('register', [$id, $name, $email, $password]);
    }

    function it_should_add_educations(Education $education)
    {
        $this->addEducation($education);

        $this->educations()->shouldHaveCount(1);
    }

    public function it_should_not_all_education_if_already_has_same_education(Education $education)
    {
        $this->addEducation($education);

        $this->shouldThrow('Workly\Domain\Exceptions\DuplicateException')->during('addEducation', [$education]);
    }

    public function it_should_add_skills(Skill $skill)
    {
        $this->addSkill($skill);

        $this->skills()->shouldHaveCount(1);
    }

    public function it_should_not_add_skill_if_already_has_skill()
    {
        $skill = new Skill('Test skill');

        $this->addSkill($skill);

        $this->shouldThrow('Workly\Domain\Exceptions\DuplicateException')->during('addSkill', [$skill]);
    }
    public function it_should_add_interest_in_companies(Company $company)
    {
        $this->addInterestInCompany($company);

        $this->interestedInCompanies()->shouldHaveCount(1);
    }

    public function it_should_not_add_interest_in_company_if_already_interested(Company $company)
    {
        $this->addInterestInCompany($company);

        $this->shouldThrow('Workly\Domain\Exceptions\DuplicateException')->during('addInterestInCompany', [$company]);
    }

    public function it_should_add_interested_companies(Company $company)
    {
        $this->addInterestedCompany($company);

        $this->interestedCompanies()->shouldHaveCount(1);
    }

    public function it_should_not_add_interested_company_if_company_already_is_interested(Company $company)
    {
        $this->addInterestedCompany($company);

        $this->shouldThrow('Workly\Domain\Exceptions\DuplicateException')->during('addInterestedCompany', [$company]);
    }

    public function it_should_add_employment(Employment $employment, Company $company)
    {
        $employment->company()->willReturn($company);

        $this->addEmployment($employment);

        $this->employments()->shouldHaveCount(1);
    }

    public function it_should_not_add_employment_if_already_has_same_employment(Employment $employment, Company $company)
    {
        $employment->company()->willReturn($company);
        $employment->position()->willReturn('Test position');

        $this->addEmployment($employment);

        $this->shouldThrow('Workly\Domain\Exceptions\DuplicateException')->during('addEmployment', [$employment]);
    }

    function it_should_add_interested_in_qualities(Quality $quality)
    {
        $this->addInterestInQuality($quality);

        $this->interestedInQualities()->shouldHaveCount(1);
    }

    function it_should_not_allow_interest_in_quality_if_already_interested(Quality $quality)
    {
        $this->addInterestInQuality($quality);
        $this->shouldThrow('Workly\Domain\Exceptions\DuplicateException')->during('addInterestInQuality', [$quality]);
    }

    function it_should_raise_user_has_registerd_event()
    {
        $this->releaseEvents()[0]->shouldHaveType('Workly\Domain\Model\User\Events\UserHasRegistered');
    }
}
