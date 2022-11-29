<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Package extends Model
{
     /**
     * Define table name
     * @var string
     */
    protected $table = 'package';

    /**
     * Set hidden field to show
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Set fillable field
     * @var array
     */
    protected $fillable = [
        'name',
        'is_meat',
        'is_offal',
        'is_egg',
        'is_chicken',
        'is_vegetable',
        'is_rice'
    ];

    /**
     * Append new field to show
     * @var array
     */
    protected $appends = [
        'meat_menu',
        'offal_menu',
        'egg_menu',
        'chicken_menu',
        'vegetable_menu',
        'rice_menu',
        'selectedRice'
    ];

    /**
     * Set value of new field
     */
    public function getMeatMenuAttribute() {
        if ($this->is_meat) {
            $meats = $this->meats()->get();
            return $meats;
        }
    }

    /**
     * Set value of new field
     */
    public function getSelectedRiceAttribute() {
        if ($this->is_meat) {
            $rices = $this->rices()->get();
            return $rices;
        }
    }

    /**
     * Set value of new field
     */
    public function getOffalMenuAttribute() {
        if ($this->is_offal) {
            $offals = $this->offals()->get();
            return $offals;
        }
    }

    /**
     * Set value of new field
     */
    public function getEggMenuAttribute() {
        if ($this->is_egg) {
            $eggs = $this->eggs()->get();
            return $eggs;
        }
    }

    /**
     * Set value of new field
     */
    public function getChickenMenuAttribute() {
        if ($this->is_chicken) {
            $chickens = $this->chickens()->get();
            return $chickens;
        }
    }

    /**
     * Set value of new field
     */
    public function getVegetableMenuAttribute() {
        if ($this->is_vegetable) {
            $vegies = $this->vegies()->get();
            return $vegies;
        }
    }

    /**
     * Set value of new field
     */
    public function getRiceMenuAttribute() {
        if ($this->is_rice) {
            $rices = $this->rices()->get();
            return $rices;
        }
    }

    /**
     * Define relation to package menu
     */
    public function meats() {
        return $this->belongsToMany(
            MeatMenu::class, 'package_meat', 'package_id', 'meat_menu_id'
        );
    }

    /**
     * Define relation to package offal
     */
    public function offals() {
        return $this->belongsToMany(
            OffalMenu::class, 'package_offal', 'package_id', 'offal_menu_id'
        );
    }

    /**
     * Define relation to egg menu
     */
    public function eggs() {
        return $this->belongsToMany(
            EggMenu::class, 'package_egg', 'package_id', 'egg_menu_id'
        );
    }

    /**
     * Define relation to chicken menu
     */
    public function chickens() {
        return $this->belongsToMany(
            ChickenMenu::class, 'package_chicken', 'package_id', 'chicken_menu_id'
        );
    }

    /**
     * Define relation to vegetable menu
     */
    public function vegies() {
        return $this->belongsToMany(
            VegetableMenu::class, 'package_vegetable', 'package_id', 'vegetable_menu_id'
        );
    }

    /**
     * Define relation to rice menu
     */
    public function rices() {
        return $this->belongsToMany(
            RiceMenu::class, 'package_rice', 'package_id', 'rice_menu_id'
        );
    }
}