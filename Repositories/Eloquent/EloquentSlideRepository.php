<?php

namespace Modules\Slider\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Slider\Events\SlideWasCreated;
use Modules\Slider\Repositories\SlideRepository;

class EloquentSlideRepository extends EloquentBaseRepository implements SlideRepository
{
    /**
     * Override for add the event on create and link media file
     *
     * @param mixed $data Data from POST request form
     *
     * @return object The created entity
     */
    public function create($data)
    {
        $slide = parent::create($data);

        event(new SlideWasCreated($slide, $data));

        return $slide;
    }

    public function update($sliderItem, $data)
    {
        $sliderItem->update($data);

        return $sliderItem;
    }

    /**
     * @param $id
     * @return Builder
     */
    public function findSlidesById($id){
        return $this->model->where('slider_id','=', $id);
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getSlidesById($id){
        return $this->findSlidesById($id)->get();
    }
}
