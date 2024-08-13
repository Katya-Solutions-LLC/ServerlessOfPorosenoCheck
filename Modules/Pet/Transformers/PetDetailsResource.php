<?php

namespace Modules\Pet\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Pet\Transformers\PetNoteResource;
use Auth;
use App\Models\User;

class PetDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $pet_note= $this->petnote;

        $user=Auth::user();
        if($user ==null){

            $user=User::where('id',$request->user_id)->first();
        }
        $user_type=$user->user_type;
        $user_id=$user->id;
 
        if($user_type =='user'){

            $pet_note->where(function ($query) use ($user_id)  {

                $query->where('created_by',$user_id)
                         ->Orwhere('is_private',0)
                         ->OrwhereHas('createdBy', function ($subQuery) {
                            $subQuery->where('user_type','admin');
                       })
                       ->OrwhereHas('createdBy', function ($subQuery) {
                        $subQuery->where('user_type','demo_admin');
                   });
               });

         }else{

            $pet_note->where(function ($query) {

                $query->where('created_by',auth()->id())

                         ->Orwhere('is_private',0);
                        
                  });

          };


    
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'pettype' => optional($this->pettype)->name,
            'breed' => optional($this->breed)->name,
            'breed_id' => $this->breed_id,
            'size' => $this->size,
            'pet_image' => $this->media->pluck('original_url')->first(),
            'date_of_birth' => $this->date_of_birth,
            'age' => $this->age,
            'gender' => $this->gender,
            'weight' => $this->weight,
            'weight_unit' => $this->weight_unit,
            'height' => $this->height,
            'height_unit' => $this->height_unit,
            'user_id' => $this->user_id,
            'status' => $this->status,         
            'pet_notes' => $this->when($user_type == 'user', function () use ($user_id) {
                return PetNoteResource::collection($this->petnote()->where(function ($query) use ($user_id) {
                    $query->where('created_by', $user_id)
                        ->orWhere('is_private', 0)
                        ->orWhereHas('createdBy', function ($subQuery) {
                            $subQuery->where('user_type', 'admin');
                        })
                        ->orWhereHas('createdBy', function ($subQuery) {
                            $subQuery->where('user_type', 'demo_admin');
                        });
                })->get());
            }, function () {
               return PetNoteResource::collection($this->petnote()->where(function ($query) {
                   $query->where('created_by', auth()->id())
                       ->orWhere('is_private', 0);
               })->get());
            }),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ];
    }
}