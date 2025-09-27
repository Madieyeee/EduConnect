    /**
     * Get the contacts sent by the user.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the contacts assigned to this admin.
     */
    public function assignedContacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'assigned_to');
    }
