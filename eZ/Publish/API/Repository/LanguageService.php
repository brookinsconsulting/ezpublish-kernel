<?php

/**
 * File containing the eZ\Publish\API\Repository\LanguageService class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Publish\API\Repository;

use eZ\Publish\API\Repository\Values\Content\LanguageCreateStruct;
use eZ\Publish\API\Repository\Values\Content\Language;

/**
 * Language service, used for language operations.
 */
interface LanguageService
{
    /**
     * Creates the a new Language in the content repository.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException If user does not have access to content translations
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException if the languageCode already exists
     *
     * @param \eZ\Publish\API\Repository\Values\Content\LanguageCreateStruct $languageCreateStruct
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language
     */
    public function createLanguage(LanguageCreateStruct $languageCreateStruct);

    /**
     * Changes the name of the language in the content repository.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException If user does not have access to content translations
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Language $language
     * @param string $newName
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language
     */
    public function updateLanguageName(Language $language, $newName);

    /**
     * Enables a language.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException If user does not have access to content translations
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Language $language
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language
     */
    public function enableLanguage(Language $language);

    /**
     * Disables a language.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException If user does not have access to content translations
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Language $language
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language
     */
    public function disableLanguage(Language $language);

    /**
     * Loads a Language from its language code ($languageCode).
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException if language could not be found
     *
     * @param string $languageCode
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language
     */
    public function loadLanguage($languageCode);

    /**
     * Loads all Languages.
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language[]
     */
    public function loadLanguages();

    /**
     * Loads a Language by its id ($languageId).
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException if language could not be found
     *
     * @param mixed $languageId
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language
     */
    public function loadLanguageById($languageId);

    /**
     * Bulk-load Languages by language codes.
     *
     * Note: it does not throw exceptions on load, just ignores erroneous Languages.
     *
     * @param string[] $languageCodes
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language[] list of Languages with language-code as keys
     */
    public function loadLanguageListByCode(array $languageCodes): iterable;

    /**
     * Bulk-load Languages by ids.
     *
     * Note: it does not throw exceptions on load, just ignores erroneous Languages.
     *
     * @param int[] $languageIds
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language[] list of Languages with id as keys
     */
    public function loadLanguageListById(array $languageIds): iterable;

    /**
     * Deletes  a language from content repository.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     *         if language can not be deleted
     *         because it is still assigned to some content / type / (...).
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException If user is not allowed to delete a language
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Language $language
     */
    public function deleteLanguage(Language $language);

    /**
     * Returns a configured default language code.
     *
     * @return string
     */
    public function getDefaultLanguageCode();

    /**
     * Instantiates an object to be used for creating languages.
     *
     * @return \eZ\Publish\API\Repository\Values\Content\LanguageCreateStruct
     */
    public function newLanguageCreateStruct();
}
