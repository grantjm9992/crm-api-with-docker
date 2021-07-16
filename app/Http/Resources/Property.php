<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Property extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $firstImage = \App\PropertiesImages::where('id_property', $this->id)->first();
      $imagePath = (is_object($firstImage)) ? env('GOOGLE_CLOUD_PUBLIC_ACCESS').$firstImage->path : null;
      
      $reservations = \App\Rentals::where("id_property", $this->id)->get();
      $res = array();
      foreach ( $reservations as $row )
      {
          $start = new \DateTime( $row->date_start );
          $end = new \DateTime( $row->date_end );
          $start->setTime("12", "00");
          $end->setTime("12", "00");
          while ( $start < $end )
          {
              $res[] = $start->format("Y-m-d");
              $start->modify("+1 days");
          }
      }
      return [
        'id' => $this->id,
        'title' => $this->title,
        'public_title' => $this->public_title,
        'images' => \App\PropertiesImages::where('id_property', $this->id)->get(),
        'image' => $imagePath,
        'features' => \App\PropertiesFeatures::join('features', 'features.id', '=', 'id_feature')->where('id_property', $this->id)->get(),
        'resort' => \App\Resort::where('id', $this->id_resort)->first(),
        'unavailable_dates' => $res,
        'reservations' => $reservations, 
        'owner' => \App\User::where('id', $this->id_property_owner)->first(),
        'type' => \App\PropertyTypes::where('id', $this->id_property_type)->first(),
        'description' => $this->description,
        'created_at' => (string) $this->created_at,
        'updated_at' => (string) $this->updated_at,
        'bedrooms' => $this->bedrooms,
        'bath' => $this->bath,
        'bed' => $this->bed,
        'location' => $this->location,
        'sleeps' => $this->sleeps,
     ];
    }
}
