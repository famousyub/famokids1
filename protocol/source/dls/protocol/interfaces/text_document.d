/*
 *Copyright (C) 2018 Laurent Tréguier
 *
 *This file is part of DLS.
 *
 *DLS is free software: you can redistribute it and/or modify
 *it under the terms of the GNU General Public License as published by
 *the Free Software Foundation, either version 3 of the License, or
 *(at your option) any later version.
 *
 *DLS is distributed in the hope that it will be useful,
 *but WITHOUT ANY WARRANTY; without even the implied warranty of
 *MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *GNU General Public License for more details.
 *
 *You should have received a copy of the GNU General Public License
 *along with DLS.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

module dls.protocol.interfaces.text_document;

import dls.protocol.definitions;
import dls.protocol.interfaces.client : TextDocumentRegistrationOptions;
import std.json : JSONValue;

final class DidOpenTextDocumentParams
{
    TextDocumentItem textDocument;

    @safe this() pure nothrow
    {
        this.textDocument = new TextDocumentItem();
    }
}

final class DidChangeTextDocumentParams
{
    VersionedTextDocumentIdentifier textDocument;
    TextDocumentContentChangeEvent[] contentChanges;

    @safe this() pure nothrow
    {
        this.textDocument = new VersionedTextDocumentIdentifier();
    }
}

final class TextDocumentContentChangeEvent
{
    import std.typecons : Nullable;

    Nullable!Range range;
    Nullable!size_t rangeLength;
    string text;

    @safe this() pure nothrow
    {
    }
}

final class TextDocumentChangeRegistrationOptions : TextDocumentRegistrationOptions
{
    import dls.protocol.interfaces.general : TextDocumentSyncKind;

    TextDocumentSyncKind syncKind;

    @safe this(TextDocumentSyncKind syncKind = TextDocumentSyncKind.init) pure nothrow
    {
        this.syncKind = syncKind;
    }
}

private class ParamsBase
{
    TextDocumentIdentifier textDocument;

    @safe this() pure nothrow
    {
        this.textDocument = new TextDocumentIdentifier();
    }
}

final class WillSaveTextDocumentParams : ParamsBase
{
    TextDocumentSaveReason reason;

    @safe this() pure nothrow
    {
    }
}

enum TextDocumentSaveReason : ubyte
{
    manual = 1,
    afterDelay = 2,
    focusOut = 3
}

final class DidSaveTextDocumentParams : ParamsBase
{
    import std.typecons : Nullable;

    Nullable!string text;

    @safe this() pure nothrow
    {
    }
}

final class TextDocumentSaveRegistrationOptions : TextDocumentRegistrationOptions
{
    import std.typecons : Nullable;

    Nullable!bool includeText;

    @safe this(Nullable!bool includeText = Nullable!bool.init) pure nothrow
    {
        this.includeText = includeText;
    }
}

alias DidCloseTextDocumentParams = ParamsBase;

final class PublishDiagnosticsParams
{
    DocumentUri uri;
    Diagnostic[] diagnostics;

    @safe this(DocumentUri uri = DocumentUri.init, Diagnostic[] diagnostics = Diagnostic[].init) pure nothrow
    {
        this.uri = uri;
        this.diagnostics = diagnostics;
    }
}

final class CompletionParams : TextDocumentPositionParams
{
    import std.typecons : Nullable;

    Nullable!CompletionContext context;

    @safe this() pure nothrow
    {
    }
}

final class CompletionContext
{
    import std.typecons : Nullable;

    CompletionTriggerKind triggerKind;
    Nullable!string triggerCharacter;

    @safe this() pure nothrow
    {
    }
}

enum CompletionTriggerKind : ubyte
{
    invoked = 1,
    triggerCharacter = 2,
    triggerForIncompleteCompletions = 3
}

final class CompletionList
{
    bool isIncomplete;
    CompletionItem[] items;

    @safe this(bool isIncomplete = bool.init, CompletionItem[] items = CompletionItem[].init) pure nothrow
    {
        this.isIncomplete = isIncomplete;
        this.items = items;
    }
}

enum InsertTextFormat : ubyte
{
    plainText = 1,
    snippet = 2
}

final class CompletionItem
{
    import std.typecons : Nullable;

    string label;
    Nullable!CompletionItemKind kind;
    Nullable!string detail;
    Nullable!MarkupContent documentation;
    Nullable!bool deprecated_;
    Nullable!bool preselect;
    Nullable!string sortText;
    Nullable!string filterText;
    Nullable!string insertText;
    Nullable!InsertTextFormat insertTextFormat;
    Nullable!TextEdit textEdit;
    Nullable!(TextEdit[]) additionalTextEdits;
    Nullable!(string[]) commitCharacters;
    Nullable!Command command;
    Nullable!JSONValue data;

    @safe this(string label = string.init, Nullable!CompletionItemKind kind = Nullable!CompletionItemKind.init,
            Nullable!string detail = Nullable!string.init,
            Nullable!MarkupContent documentation = Nullable!MarkupContent.init,
            Nullable!bool deprecated_ = Nullable!bool.init, Nullable!string sortText = Nullable!string.init,
            Nullable!string filterText = Nullable!string.init, Nullable!string insertText = Nullable!string.init,
            Nullable!InsertTextFormat insertTextFormat = Nullable!InsertTextFormat.init,
            Nullable!TextEdit textEdit = Nullable!TextEdit.init,
            Nullable!(TextEdit[]) additionalTextEdits = Nullable!(TextEdit[])
            .init, Nullable!(string[]) commitCharacters = Nullable!(string[])
            .init, Nullable!Command command = Nullable!Command.init,
            Nullable!JSONValue data = Nullable!JSONValue.init) pure nothrow
    {
        this.label = label;
        this.kind = kind;
        this.detail = detail;
        this.documentation = documentation;
        this.deprecated_ = deprecated_;
        this.sortText = sortText;
        this.filterText = filterText;
        this.insertText = insertText;
        this.insertTextFormat = insertTextFormat;
        this.textEdit = textEdit;
        this.additionalTextEdits = additionalTextEdits;
        this.commitCharacters = commitCharacters;
        this.command = command;
        this.data = data;
    }
}

enum CompletionItemKind : ubyte
{
    text = 1,
    method = 2,
    function_ = 3,
    constructor = 4,
    field = 5,
    variable = 6,
    class_ = 7,
    interface_ = 8,
    module_ = 9,
    property = 10,
    unit = 11,
    value = 12,
    enum_ = 13,
    keyword = 14,
    snippet = 15,
    color = 16,
    file = 17,
    reference = 18,
    folder = 19,
    enumMember = 20,
    constant = 21,
    struct_ = 22,
    event = 23,
    operator = 24,
    typeParameter = 25
}

final class CompletionRegistrationOptions : TextDocumentRegistrationOptions
{
    import std.typecons : Nullable;

    Nullable!(string[]) triggerCharacters;
    Nullable!bool resolveProvider;

    @safe this(Nullable!(string[]) triggerCharacters = Nullable!(string[])
            .init, Nullable!bool resolveProvider = Nullable!bool.init) pure nothrow
    {
        this.triggerCharacters = triggerCharacters;
        this.resolveProvider = resolveProvider;
    }
}

final class Hover
{
    import std.typecons : Nullable;

    MarkupContent contents;
    Nullable!Range range;

    @safe this(MarkupContent contents = MarkupContent.init,
            Nullable!Range range = Nullable!Range.init) pure nothrow
    {
        this.contents = contents;
        this.range = range;
    }
}

final class SignatureHelp
{
    import std.typecons : Nullable;

    SignatureInformation[] signatures;
    Nullable!double activeSignature;
    Nullable!double activeParameter;

    @safe this(SignatureInformation[] signatures = SignatureInformation[].init,
            Nullable!double activeSignature = Nullable!double.init,
            Nullable!double activeParameter = Nullable!double.init) pure nothrow
    {
        this.signatures = signatures;
        this.activeSignature = activeSignature;
        this.activeParameter = activeParameter;
    }
}

private class InformationBase
{
    import std.typecons : Nullable;

    string label;
    Nullable!string documentation;

    @safe this() pure nothrow
    {
    }
}

final class SignatureInformation : InformationBase
{
    import std.typecons : Nullable;

    Nullable!(ParameterInformation[]) parameters;

    @safe this(Nullable!(ParameterInformation[]) parameters = Nullable!(
            ParameterInformation[]).init) pure nothrow
    {
        this.parameters = parameters;
    }
}

final class ParameterInformation : InformationBase
{
    JSONValue label;

    @safe this() pure nothrow
    {
    }
}

final class SignatureHelpRegistrationOptions : TextDocumentRegistrationOptions
{
    import std.typecons : Nullable;

    Nullable!(string[]) triggerCharacters;

    @safe this(Nullable!(string[]) triggerCharacters = Nullable!(string[]).init) pure nothrow
    {
        this.triggerCharacters = triggerCharacters;
    }
}

final class ReferenceParams : TextDocumentPositionParams
{
    ReferenceContext context;

    @safe this() pure nothrow
    {
        this.context = new ReferenceContext();
    }
}

final class ReferenceContext
{
    bool includeDeclaration;

    @safe this() pure nothrow
    {
    }
}

final class DocumentHighlight
{
    import std.typecons : Nullable;

    Range range;
    Nullable!DocumentHighlightKind kind;

    @safe this(Range range = new Range(),
            Nullable!DocumentHighlightKind kind = Nullable!DocumentHighlightKind.init) pure nothrow
    {
        this.range = range;
        this.kind = kind;
    }
}

enum DocumentHighlightKind : ubyte
{
    text = 1,
    read = 2,
    write = 3
}

alias DocumentSymbolParams = ParamsBase;

final class DocumentSymbol
{
    import std.typecons : Nullable;

    string name;
    Nullable!string detail;
    SymbolKind kind;
    Nullable!bool deprecated_;
    Range range;
    Range selectionRange;
    Nullable!(DocumentSymbol[]) children;

    @safe this(string name = string.init, Nullable!string detail = Nullable!string.init,
            SymbolKind kind = SymbolKind.init, Nullable!bool deprecated_ = Nullable!bool.init,
            Range range = new Range(), Range selectionRange = new Range(),
            Nullable!(DocumentSymbol[]) children = Nullable!(DocumentSymbol[]).init) pure nothrow
    {
        this.name = name;
        this.detail = detail;
        this.kind = kind;
        this.deprecated_ = deprecated_;
        this.range = range;
        this.selectionRange = selectionRange;
        this.children = children;
    }
}

final class SymbolInformation
{
    import std.typecons : Nullable;

    string name;
    SymbolKind kind;
    Location location;
    Nullable!string containerName;

    @safe this(string name = string.init, SymbolKind kind = SymbolKind.init,
            Location location = new Location(),
            Nullable!string containerName = Nullable!string.init) pure nothrow
    {
        this.name = name;
        this.kind = kind;
        this.location = location;
        this.containerName = containerName;
    }
}

enum SymbolKind : ubyte
{
    file = 1,
    module_ = 2,
    namespace = 3,
    package_ = 4,
    class_ = 5,
    method = 6,
    property = 7,
    field = 8,
    constructor = 9,
    enum_ = 10,
    interface_ = 11,
    function_ = 12,
    variable = 13,
    constant = 14,
    string_ = 15,
    number = 16,
    boolean = 17,
    array = 18,
    object = 19,
    key = 20,
    null_ = 21,
    enumMember = 22,
    struct_ = 23,
    event = 24,
    operator = 25,
    typeParameter = 26
}

final class CodeActionParams : ParamsBase
{
    Range range;
    CodeActionContext context;

    @safe this() pure nothrow
    {
        this.range = new Range();
        this.context = new CodeActionContext();
    }
}

enum CodeActionKind : string
{
    quickfix = "quickfix",
    refactor = "refactor",
    refactorExtract = "refactor.extract",
    refactorInline = "refactor.inline",
    source = "source",
    sourceOrganizeImports = "source.organizeImports"
}

final class CodeActionContext
{
    import std.typecons : Nullable;

    Diagnostic[] diagnostics;
    Nullable!(CodeActionKind[]) only;

    @safe this() pure nothrow
    {
    }
}

final class CodeAction
{
    import std.typecons : Nullable;

    string title;
    Nullable!CodeActionKind kind;
    Nullable!(Diagnostic[]) diagnostics;
    Nullable!WorkspaceEdit edit;
    Nullable!Command command;

    @safe this(string title = string.init, Nullable!CodeActionKind kind = Nullable!CodeActionKind.init,
            Nullable!(Diagnostic[]) diagnostics = Nullable!(Diagnostic[]).init,
            Nullable!WorkspaceEdit edit = Nullable!WorkspaceEdit.init,
            Nullable!Command command = Nullable!Command.init) pure nothrow
    {
        this.title = title;
        this.kind = kind;
        this.diagnostics = diagnostics;
        this.edit = edit;
        this.command = command;
    }
}

alias CodeActionRegistrationOptions = JSONValue;

alias CodeLensParams = ParamsBase;

final class CodeLens
{
    import std.typecons : Nullable;

    Range range;
    Nullable!Command command;
    Nullable!JSONValue data;

    @safe this(Range range = new Range(), Nullable!Command command = Nullable!Command.init,
            Nullable!JSONValue data = Nullable!JSONValue.init) pure nothrow
    {
        this.range = range;
        this.command = command;
        this.data = data;
    }
}

final class CodeLensRegistrationOptions : TextDocumentRegistrationOptions
{
    import std.typecons : Nullable;

    Nullable!bool resolveProvider;

    @safe this(Nullable!bool resolveProvider = Nullable!bool.init) pure nothrow
    {
        this.resolveProvider = resolveProvider;
    }
}

alias DocumentLinkParams = ParamsBase;

final class DocumentLink
{
    import std.typecons : Nullable;

    Range range;
    Nullable!DocumentUri target;

    @safe this(Range range = new Range(), Nullable!DocumentUri target = Nullable!DocumentUri.init) pure nothrow
    {
        this.range = range;
        this.target = target;
    }
}

final class DocumentLinkRegistrationOptions : TextDocumentRegistrationOptions
{
    import std.typecons : Nullable;

    Nullable!bool resolveProvider;

    @safe this(Nullable!bool resolveProvider = Nullable!bool.init) pure nothrow
    {
        this.resolveProvider = resolveProvider;
    }
}

alias DocumentColorParams = ParamsBase;

final class ColorInformation
{
    Range range;
    Color color;

    @safe this(Range range = new Range(), Color color = new Color()) pure nothrow
    {
        this.range = range;
        this.color = color;
    }
}

final class Color
{
    float red;
    float green;
    float blue;
    float alpha;

    @safe this(float red = 0, float green = 0, float blue = 0, float alpha = 0) pure nothrow
    {
        this.red = red;
        this.green = green;
        this.blue = blue;
        this.alpha = alpha;
    }
}

final class ColorPresentationParams : ParamsBase
{
    Color color;
    Range range;

    @safe this() pure nothrow
    {
        this.color = new Color();
        this.range = new Range();
    }
}

final class ColorPresentation
{
    import std.typecons : Nullable;

    string label;
    Nullable!TextEdit textEdit;
    Nullable!(TextEdit[]) additionalTextEdits;

    @safe this(string label = string.init, Nullable!TextEdit textEdit = Nullable!TextEdit.init,
            Nullable!(TextEdit[]) additionalTextEdits = Nullable!(TextEdit[]).init) pure nothrow
    {
        this.label = label;
        this.textEdit = textEdit;
        this.additionalTextEdits = additionalTextEdits;
    }
}

class DocumentFormattingParams : ParamsBase
{
    FormattingOptions options;

    @safe this() pure nothrow
    {
        this.options = new FormattingOptions();
    }
}

final class FormattingOptions
{
    size_t tabSize;
    bool insertSpaces;

    @safe this() pure nothrow
    {
    }
}

final class DocumentRangeFormattingParams : DocumentFormattingParams
{
    Range range;

    @safe this() pure nothrow
    {
        this.range = new Range();
    }
}

final class DocumentOnTypeFormattingParams : DocumentFormattingParams
{
    Position position;
    string ch;

    @safe this() pure nothrow
    {
        this.position = new Position();
    }
}

final class DocumentOnTypeFormattingRegistrationOptions : TextDocumentRegistrationOptions
{
    import std.typecons : Nullable;

    string firstTriggerCharacter;
    Nullable!(string[]) moreTriggerCharacter;

    @safe this(string firstTriggerCharacter = string.init,
            Nullable!(string[]) moreTriggerCharacter = Nullable!(string[]).init) pure nothrow
    {
        this.firstTriggerCharacter = firstTriggerCharacter;
        this.moreTriggerCharacter = moreTriggerCharacter;
    }
}

final class RenameParams : ParamsBase
{
    Position position;
    string newName;

    @safe this() pure nothrow
    {
        this.position = new Position();
    }
}

final class RenameRegistrationOptions : TextDocumentRegistrationOptions
{
    import std.typecons : Nullable;

    Nullable!bool prepareProvider;

    @safe this() pure nothrow
    {
    }
}

alias FoldingRangeParams = ParamsBase;

enum FoldingRangeKind : string
{
    comments = "comments",
    imports = "imports",
    region = "region"
}

final class FoldingRange
{
    import std.typecons : Nullable;

    size_t startLine;
    Nullable!size_t startCharacter;
    size_t endLine;
    Nullable!size_t endCharacter;
    Nullable!FoldingRangeKind kind;

    @safe this() pure nothrow
    {
    }
}
