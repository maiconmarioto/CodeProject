<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
	protected $fillable = [
		'name',
		'owner_id',
		'client_id',
		'description',
		'progress',
		'status',
		'due_date',
	];

	public function notes() {
		return $this->hasMany(ProjectNote::class);
	}

	public function tasks() {
		return $this->hasMany(ProjectTask::class);
	}

	public function files() {
		return $this->hasMany(ProjectFile::class);
	}

	public function members() {
		return $this->hasMany('\CodeProject\Entities\User', 'id', 'member_id');
	}

	public function client() {
		return $this->hasMany('\CodeProject\Entities\Client', 'id', 'client_id');
	}

	public function owner() {
		return $this->hasOne('\CodeProject\Entities\User', 'id', 'owner_id');
	}
}
