<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Dataflow;

class SourceOperationResponse extends \Google\Model
{
  /**
   * @var SourceGetMetadataResponse
   */
  public $getMetadata;
  protected $getMetadataType = SourceGetMetadataResponse::class;
  protected $getMetadataDataType = '';
  /**
   * @var SourceSplitResponse
   */
  public $split;
  protected $splitType = SourceSplitResponse::class;
  protected $splitDataType = '';

  /**
   * @param SourceGetMetadataResponse
   */
  public function setGetMetadata(SourceGetMetadataResponse $getMetadata)
  {
    $this->getMetadata = $getMetadata;
  }
  /**
   * @return SourceGetMetadataResponse
   */
  public function getGetMetadata()
  {
    return $this->getMetadata;
  }
  /**
   * @param SourceSplitResponse
   */
  public function setSplit(SourceSplitResponse $split)
  {
    $this->split = $split;
  }
  /**
   * @return SourceSplitResponse
   */
  public function getSplit()
  {
    return $this->split;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(SourceOperationResponse::class, 'Google_Service_Dataflow_SourceOperationResponse');
