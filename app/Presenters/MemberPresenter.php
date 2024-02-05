<?php

namespace Vanguard\Presenters;

use Vanguard\Support\Enum\MemberStatus;
use Illuminate\Support\Str;

class MemberPresenter extends Presenter
{
    public function name()
    {
        return sprintf("%s %s", $this->model->first_name, $this->model->last_name);
    }

    public function nameOrEmail()
    {
        return trim($this->name()) ?: $this->model->email;
    }

    public function avatar()
    {
        if (! $this->model->avatar) {
            return url('assets/img/profile.png');
        }

        return Str::contains($this->model->avatar, ['http', 'gravatar'])
            ? $this->model->avatar
            : url("upload/members/{$this->model->avatar}");
    }

    public function birthday()
    {
        return $this->model->birthday
            ? $this->model->birthday->format(config('app.date_format'))
            : 'N/A';
    }

    public function fullAddress()
    {
        $address = '';
        $member = $this->model;

        if ($member->address) {
            $address .= $member->address;
        }

        if ($member->country_id) {
            $address .= $member->address ? ", {$member->country->name}" : $member->country->name;
        }

        return $address ?: 'N/A';
    }

    public function lastLogin()
    {
        return $this->model->last_login
            ? $this->model->last_login->diffForHumans()
            : 'N/A';
    }

    /**
     * Determine css class used for status labels
     * inside the users table by checking user status.
     *
     * @return string
     */
    public function labelClass()
    {
        switch ($this->model->status) {
            case MemberStatus::ACTIVE:
                $class = 'success';
                break;

            case MemberStatus::BANNED:
                $class = 'danger';
                break;

            default:
                $class = 'warning';
        }

        return $class;
    }
}
