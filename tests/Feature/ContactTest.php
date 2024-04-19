<?php

use App\Models\Contact;
use App\Models\Deal;
use App\Models\Interest;

it('get all contacts that share interests with the deal', function () {
    Interest::factory(5)->create();
    $deal = Deal::factory()->create();
    $contacts = Contact::factory(3)->create();

    $deal->interests()->sync(Interest::take(3)->pluck('id')->toArray());
    $contacts[0]->interests()->sync(Interest::take(3)->pluck('id')->toArray());
    $contacts[1]->interests()->sync(Interest::take(1)->pluck('id')->toArray());

    $notify = Contact::getByDeal($deal);

    expect($notify->pluck('id')->toArray())->toMatchArray([$contacts[0]->id, $contacts[1]->id]);
});
