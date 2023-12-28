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

namespace Google\Service\Dataform;

class CommitWorkspaceChangesRequest extends \Google\Collection
{
  protected $collection_key = 'paths';
  /**
   * @var CommitAuthor
   */
  public $author;
  protected $authorType = CommitAuthor::class;
  protected $authorDataType = '';
  /**
   * @var string
   */
  public $commitMessage;
  /**
   * @var string[]
   */
  public $paths;

  /**
   * @param CommitAuthor
   */
  public function setAuthor(CommitAuthor $author)
  {
    $this->author = $author;
  }
  /**
   * @return CommitAuthor
   */
  public function getAuthor()
  {
    return $this->author;
  }
  /**
   * @param string
   */
  public function setCommitMessage($commitMessage)
  {
    $this->commitMessage = $commitMessage;
  }
  /**
   * @return string
   */
  public function getCommitMessage()
  {
    return $this->commitMessage;
  }
  /**
   * @param string[]
   */
  public function setPaths($paths)
  {
    $this->paths = $paths;
  }
  /**
   * @return string[]
   */
  public function getPaths()
  {
    return $this->paths;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(CommitWorkspaceChangesRequest::class, 'Google_Service_Dataform_CommitWorkspaceChangesRequest');
